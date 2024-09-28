<?php

namespace App\Livewire\Admin\Mahasiswa;

use Livewire\Component;
use App\Models\Mahasiswa;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public $search = '';

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
    // Use render method to return paginated data
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
