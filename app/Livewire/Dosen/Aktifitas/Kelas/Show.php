<?php

namespace App\Livewire\Dosen\Aktifitas\Kelas;

use App\Exports\NilaiExport;
use App\Models\Aktifitas;
use App\Models\Kelas;
use App\Models\Matakuliah;
use App\Models\Nilai;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Imports\NilaiImport;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Excel;
use Storage;

class Show extends Component
{
    use WithFileUploads;
    public $id_kelas, $kode_mata_kuliah, $id_mata_kuliah, $CheckDosen = false, $file, $nama_kelas;

    #[On('aktifitasCreated')]
    public function handleAktifitasCreated()
    {
        $this->dispatch('pg:eventRefresh-aktifitas-table-fonjfc-table');
        $this->dispatch('created', ['message' => 'Aktifitas Created Successfully']);
    }
    #[On('aktifitasUpdated')]
    public function handleAktifitasUpdated()
    {
        $this->dispatch('pg:eventRefresh-aktifitas-table-fonjfc-table');
        $this->dispatch('updated', ['message' => 'Aktifitas Updated Successfully']);
    }
    #[On('kelasUpdated')]
    public function handelKelasUpdated()
    {
        $this->dispatch('pg:eventRefresh-aktifitas-table-fonjfc-table');
        $this->dispatch('updated', ['message' => 'Bobot Berhasil Diupdate']);

    }
     #[On('nilaiUpdated')]
    public function handelNilaiUpdated()
    {
        $this->dispatch('pg:eventRefresh-aktifitas-table-fonjfc-table');
        $this->dispatch('updated', ['message' => 'Nilai Berhasil Diupdate']);

    }
         #[On('aktivitasDeleted')]
    public function handelAktivitasDeletedd()
    {
        $this->dispatch('pg:eventRefresh-aktifitas-table-fonjfc-table');
        $this->dispatch('destroyed', ['message' => 'NilAktifitas dan Nilaiai Berhasil dihapus']);

    }
    public function mount()
    {
        $this->id_mata_kuliah = Matakuliah::where('kode_mata_kuliah', $this->kode_mata_kuliah)->where('nidn', Auth()->user()->nim_nidn)->first()->id_mata_kuliah;

        $this->id_kelas = kelas::where('nama_kelas', str_replace('-', '/', $this->nama_kelas))->first()->id_kelas;

        $this->CheckDosen = (Matakuliah::where('id_mata_kuliah', $this->id_mata_kuliah)->where('nidn', Auth()->user()->nim_nidn)->exists());
    }

    public function destroy($id_aktifitas)
    {
        $acara = Aktifitas::find($id_aktifitas);

        $nilaiRecords = Nilai::where('id_aktifitas', $id_aktifitas)
            ->where('id_kelas', $this->id_kelas)
            ->get();

        foreach ($nilaiRecords as $nilai) {
            $nilai->delete();
        }
        $acara->delete();
        $this->dispatch('pg:eventRefresh-aktifitas-table-fonjfc-table');

        $this->dispatch('destroyed', ['message' => 'Aktifitas dan Nilai deleted successfully']);

    }


    public function import(Excel $excel)
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx|max:10240',
        ]);

        $path = $this->file->store('temp');

        $skippedRecords = [];
        $createdRecords = [];

        $import = new NilaiImport($this->id_kelas, $this->kode_mata_kuliah);

        try {
            $excel->import($import, Storage::path($path));

            $skippedRecords = $import->getSkippedRecords();
            $createdRecords = $import->getCreatedRecords();
            $incompleteRecords = $import->getIncompleteRecords();
            $updatedRecords = $import->getUpdatedRecords();
            if (empty($createdRecords) && empty($updatedRecords)) {
                session()->flash('message', 'Tidak ada data yang disimpan');
                session()->flash('message_type', 'error');
            } else if (empty($createdRecords) && !empty($updatedRecords)) {
                $this->dispatch('updated', ['message' => count($updatedRecords) . ' data berhasil diupdate']);
            } else if (!empty($createdRecords) && empty($updatedRecords)) {
                $this->dispatch('created', ['message' => count($createdRecords) . ' data berhasil disimpan']);
            } else {
                $this->dispatch('created', ['message' => count($createdRecords) . ' data berhasil disimpan dan ' . count($updatedRecords) . ' data berhasil diupdate']);
            }
            if ($skippedRecords > 0 && !empty($incompleteRecords)) {

                session()->flash('message2', $skippedRecords . ' Data sudah ada <br>' . implode($incompleteRecords));
                session()->flash('message_type2', 'warning');

            } elseif ($skippedRecords > 0 && empty($incompleteRecords)) {
                session()->flash('message2', $skippedRecords . ' Data sudah ada');
                session()->flash('message_type2', 'warning');
            } elseif ($skippedRecords == 0 && !empty($incompleteRecords)) {
                session()->flash('message2', implode($incompleteRecords));
                session()->flash('message_type2', 'warning');
            }
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            session()->flash('message', 'Invalid file format: ' . $e->getMessage());
            session()->flash('message_type', 'error');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') {
                session()->flash('message', 'Data Sudah Ada ' . $e->getMessage());
                session()->flash('message_type', 'error');
            } else {
                session()->flash('message', 'Database error: ' . $e->getMessage());
                session()->flash('message_type', 'error');
            }
        } catch (\Exception $e) {
            session()->flash('message', 'An error occurred: ' . $e->getMessage());
            session()->flash('message_type', 'error');
        } finally {
            $this->reset('file');
            $this->importing = false;
            $this->dispatch('pg:eventRefresh-aktifitas-table-fonjfc-table');

        }
    }

    public function export(Excel $excel)
    {
        $nama_kelas = str_replace('/', '-', Kelas::where('id_kelas', $this->id_kelas)->first()->nama_kelas);
        $fileName = 'Data Aktifitas ' . $nama_kelas . ' ' . now()->format('Y-m-d') . '.xlsx';
        return $excel->download(new NilaiExport($this->id_kelas, $this->id_mata_kuliah), $fileName);
    }


    public function render()
    {
        $aktifitas = Aktifitas::where('id_kelas', $this->id_kelas)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->orderByRaw("
                CASE 
                    WHEN LOWER(TRIM(nama_aktifitas)) IN ('uts', 'uas', 'partisipasi') THEN 
                CASE 
                    WHEN LOWER(TRIM(nama_aktifitas)) = 'uts' THEN 2
                    WHEN LOWER(TRIM(nama_aktifitas)) = 'uas' THEN 3
                    WHEN LOWER(TRIM(nama_aktifitas)) = 'partisipasi' THEN 4
                ELSE 1
                END
            ELSE 1
        END
    ")
            ->get();

        if (!$aktifitas->contains('nama_aktifitas', 'Partisipasi')) {
            (new Aktifitas)->createNilaiPartisipasi($this->id_mata_kuliah);
        }
        return view('livewire.dosen.aktifitas.kelas.show', [
            'aktifitas' => $aktifitas
        ]);
    }
}
