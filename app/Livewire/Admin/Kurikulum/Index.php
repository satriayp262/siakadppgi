<?php

namespace App\Livewire\Admin\Kurikulum;

use Livewire\Component;
use App\Models\Kurikulum;
use App\Models\Prodi;
use App\Imports\KurikulumImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;
use App\Models\Semester;


class Index extends Component
{
    public $file;
    public $id_kurikulum;
    public $selectedKurikulum = [];
    public $selectAll = false;
    public $showDeleteButton = false;

    use WithFileUploads;


    #[On('KurikulumCreated')]
    public function handleKurikulumCreated()
    {
        $this->dispatch('created', ['message' => 'Kurikulum Berhasil Ditambahkan']);
    }

    #[On('KurikulumUpdated')]
    public function handleKurikulumUpdated()
    {
        $this->dispatch('updated', ['message' => 'Kurikulum Berhasil Diubah']);
    }

    public function destroy($id_kurikulum)
    {
        $kurikulum = Kurikulum::find($id_kurikulum);
        $kurikulum->delete();

        $this->dispatch('deleted', ['message' => 'Kurikulum Berhasil Dihapus']);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Jika selectAll true, pilih semua id_kurikulum
            $this->selectedKurikulum = Kurikulum::pluck('id_kurikulum')->toArray();
        } else {
            // Jika selectAll false, hapus semua pilihan
            $this->selectedKurikulum = [];
        }
    }

    public function updatedSelectedKurikulum()
    {
        // Jika ada kurikulum yang dipilih, tampilkan tombol, jika tidak, sembunyikan
        $this->showDeleteButton = count($this->selectedKurikulum) > 0;
    }

    public function destroySelected()
    {
        // Hapus data kurikulum yang terpilih
        Kurikulum::whereIn('id_kurikulum', $this->selectedKurikulum)->delete();

        // Reset array selectedKurikulum setelah penghapusan
        $this->selectedKurikulum = [];
        $this->selectAll = false; // Reset juga selectAll

        // Emit event ke frontend untuk reset checkbox
        $this->dispatch('kurikulumDeleted');
    }
    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx|max:10240',
        ]);
        $path = $this->file->store('temp');

        // $skippedRecords = [];
        $createdRecords = [];

        $import = new KurikulumImport();

        try {

            Excel::import($import, Storage::path($path));
            $skippedRecords = $import->getSkippedRecords();
            $createdRecords = $import->getCreatedRecords();
            $incompleteRecords = $import->getIncompleteRecords();
            if (empty($createdRecords)) {
                session()->flash('message', 'Tidak ada data yang disimpan');
                session()->flash('message_type', 'error');
            } else {
                $this->dispatch('created', ['message' => count($createdRecords) . ' Kurikulum Berhasil disimpan']);
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
        }
    }

    public function render()
    {
        $kurikulums = Kurikulum::all();
        $prodis = Prodi::all();
        $semesters = Semester::all();

        return view('livewire.admin.kurikulum.index', [
            'kurikulums' => $kurikulums,
            'prodis' => $prodis,
            'semesters' => $semesters
        ]);
    }
}
