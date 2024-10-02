<?php

namespace App\Livewire\Admin\Mahasiswa;

use Livewire\Component;
use App\Models\Mahasiswa;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
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
        // Validate that the file is provided and is a valid Excel file
        $this->validate([
            'file' => 'required|mimes:xls,xlsx|max:10240', // max 10MB
        ]);

        // Store the file temporarily
        $path = $this->file->store('temp');

        // Use Excel to import the file
        Excel::import(new MahasiswaImport, storage_path('app/' . $path));

        // Emit a success message or refresh the page
        session()->flash('message', 'Mahasiswa Berhasil dimpor.');

        // Optionally, reset the file input after import
        $this->reset('file');
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
