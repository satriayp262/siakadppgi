<?php

namespace App\Livewire\Admin\Kelas;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\Kelas;
use App\Imports\KelasImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;

class Index extends Component
{

    use WithPagination;
    use WithFileUploads;

    public $file;
    public $search = '';
    public $selectedKelas = [];
    public $selectAll = false;
    public $showDeleteButton = false;

    #[On('kelasCreated')]
    public function handleKelasCreated()
    {
        $this->dispatch('created', ['message' => 'Kelas Berhasil Disimpan']);
    }


    #[On('kelasUpdated')]
    public function handleKelasUpdated()
    {
        $this->dispatch('updated', ['message' => 'Kelas Berhasil Diupdate']);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Jika selectAll true, pilih semua id_dosen
            $this->selectedKelas = Kelas::pluck('id_kelas')->toArray();
        } else {
            // Jika selectAll false, hapus semua pilihan
            $this->selectedKelas = [];
        }
    }

    public function updatedSelectedKelas()
    {
        // Jika ada dosen yang dipilih, tampilkan tombol, jika tidak, sembunyikan
        $this->showDeleteButton = count($this->selectedKelas) > 0;
    }
    public function destroySelected()
    {
        // Hapus data dosen yang terpilih
        Kelas::whereIn('id_kelas', $this->selectedKelas)->delete();

        // Reset array selectedDosen setelah penghapusan
        $this->selectedKelas = [];
        $this->selectAll = false; // Reset juga selectAll

        $this->dispatch('destroyed', ['message' => 'Kelas Berhasil Dihapus']);
        $this->showDeleteButton = false;
    }


    public function destroy($id_kelas)
    {
        $kelas = Kelas::find($id_kelas);

        // Hapus data kelas
        $kelas->delete();

        $this->dispatch('destroyed', params: ['message' => 'Kelas deleted Successfully']);
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx|max:10240',
        ]);
        $path = $this->file->store('temp');

        // $skippedRecords = [];
        $createdRecords = [];

        $import = new KelasImport();

        try {

            Excel::import($import, Storage::path($path));
            $skippedRecords = $import->getSkippedRecords();
            $createdRecords = $import->getCreatedRecords();
            $incompleteRecords = $import->getIncompleteRecords();
            if (empty($createdRecords)) {
                session()->flash('message', 'Tidak ada data yang disimpan');
                session()->flash('message_type', 'error');
            } else {
                $this->dispatch('created', ['message' => count($createdRecords) . ' Kelas Berhasil disimpan']);
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

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $kelases = Kelas::query()
            ->Where('nama_kelas', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);

        return view('livewire.admin.kelas.index', [
            'kelases' => $kelases,
        ]);
    }
}
