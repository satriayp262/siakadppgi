<?php

namespace App\Livewire\Admin\Mahasiswa;

use Livewire\Component;
use App\Models\Mahasiswa;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MahasiswaImport;

class Index extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search = '';
    

    public $file;

    // Update pagination when 'search' is updated
    protected $updatesQueryString = ['search'];

    // Reset pagination page on search update
    public function updatingSearch()
    {
        $this->resetPage();
    }

    #[On('mahasiswaUpdated')]
    public function handleMahasiswaEdited()
    {
        session()->flash('message', 'Mahasiswa Berhasil di Update');
        session()->flash('message_type', 'warning');
    }

    public function destroy($id_mahasiswa)
    {
        $mahasiswa = Mahasiswa::find($id_mahasiswa);
        $mahasiswa->delete();
        session()->flash('message', 'Mahasiswa Berhasil di Hapus');
        session()->flash('message_type', 'error');
    }

    #[On('mahasiswaCreated')]
    public function handleMahasiswaCreated()
    {
        session()->flash('message', 'Mahasiswa Berhasil di Tambahkan');
        session()->flash('message_type', 'success');
    }
    
    public function import()
    {
        // Validate the uploaded file
        $this->validate([
            'file' => 'required|mimes:xls,xlsx|max:10240',
        ]);
    
        // Store the uploaded file temporarily
        $path = $this->file->store('temp');
    
        try {
            Excel::import(new MahasiswaImport, Storage::path($path));
            session()->flash('message', 'Mahasiswa Berhasil dimpor.');
            session()->flash('message_type', 'success');
        } catch ( \Maatwebsite\Excel\Validators\ValidationException $e) {
            session()->flash('message', 'Invalid file format: ' . $e->getMessage());
            session()->flash('message_type', 'error');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000') { 
                session()->flash('message', 'Duplicate entry or invalid data: ' . $e->getMessage());
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
        $query = Mahasiswa::query();

        if ($this->search) {
            $query->where('nama', 'like', '%' . $this->search . '%')
                ->orWhere('NIM', 'like', '%' . $this->search . '%')
                ->orWhere('email', 'like', '%' . $this->search . '%');
        }

        $mahasiswas = $query->latest()->paginate(5);

        return view('livewire.admin.mahasiswa.index', [
            'mahasiswas' => $mahasiswas,
        ]);
    }
}
