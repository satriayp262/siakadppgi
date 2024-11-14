<?php

namespace App\Livewire\Admin\Dosen;

use App\Models\Dosen;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DosenImport;

class Index extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $file;

    public $id_dosen, $nama_dosen, $nidn, $jenis_kelamin, $jabatan_fungsional, $kepangkatan, $kode_prodi, $email, $password;
    public $selectedDosen = [];
    public $selectAll = false;
    public $showDeleteButton = false;

    #[On('dosenCreated')]
    public function handledosenCreated()
    {
        $this->dispatch('created', params: ['message' => 'Dosen created Successfully']);
    }
    #[On('userCreated')]
    public function handleuserCreated()
    {
        $this->dispatch('created', params: ['message' => 'User created Successfully']);
    }

    #[On('dosenUpdated')]
    public function handledosenEdited()
    {
        $this->dispatch('updated', params: ['message' => 'Dosen updated Successfully']);
    }


    public function destroy($id_dosen)
    {
        $dosen = Dosen::find($id_dosen);

        // Hapus data dosen
        $dosen->delete();

        $this->dispatch('destroyed', params: ['message' => 'Dosen deleted Successfully']);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Jika selectAll true, pilih semua id_dosen
            $this->selectedDosen = Dosen::pluck('id_dosen')->toArray();
        } else {
            // Jika selectAll false, hapus semua pilihan
            $this->selectedDosen = [];
        }
    }

    public function updatedSelectedDosen()
    {
        $this->showDeleteButton = count($this->selectedDosen) > 0;
    }

    public function destroySelected()
    {
        Dosen::whereIn('id_dosen', $this->selectedDosen)->delete();

        $this->selectedDosen = [];
        $this->selectAll = false;
        session()->flash('message', 'Dosen Berhasil di Hapus');
        session()->flash('message_type', 'error');
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xls,xlsx|max:10240',
        ]);
        $path = $this->file->store('temp');

        $createdRecords = [];

        $import = new DosenImport();

        try {
            Excel::import($import, Storage::path($path));

            $skippedRecords = $import->getSkippedRecords();
            $createdRecords = $import->getCreatedRecords();
            $incompleteRecords = $import->getIncompleteRecords();
            if (empty($createdRecords)) {
                session()->flash('message', 'Tidak ada data yang disimpan');
                session()->flash('message_type', 'error');
            } else {
                $this->dispatch('created', ['message' => count($createdRecords) . ' Dosen Berhasil disimpan']);
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
        $dosens = Dosen::query()
            ->where('nama_dosen', 'like', '%' . $this->search . '%')
            ->orWhere('nidn', 'like', '%' . $this->search . '%')
            ->orWhere('jenis_kelamin', 'like', '%' . $this->search . '%')
            ->orWhere('jabatan_fungsional', 'like', '%' . $this->search . '%')
            ->orWhere('kepangkatan', 'like', '%' . $this->search . '%')
            ->orWhere('kode_prodi', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.dosen.index', [
            'dosens' => $dosens,
        ]);
    }
}
