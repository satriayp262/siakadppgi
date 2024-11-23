<?php

namespace App\Livewire\Admin\Prodi;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Models\Prodi;


class Index extends Component
{
    public $search = '';
    public $selectedProdi = [];
    public $selectAll = false;
    public $showDeleteButton = false;

    use WithPagination;

    #[On('ProdiCreated')]
    public function handleProdiCreated()
    {
        // session()->flash('message', 'Prodi Berhasil di Tambahkan');
        // session()->flash('message_type', 'success');
        $this->dispatch('created', ['message' => 'Prodi Berhasil di Tambahkan']);
    }

    #[On('ProdiUpdated')]
    public function handleProdiUpdated()
    {
        // session()->flash('message', 'Prodi Berhasil di Update');
        // session()->flash('message_type', 'update');
        $this->dispatch('updated', ['message' => 'Prodi Berhasil di Update']);
    }
    public function updatedSelectAll($value)
    {
        if ($value) {
            // Jika selectAll true, pilih semua id_dosen
            $this->selectedProdi = Prodi::pluck('id_prodi')->toArray();
        } else {
            // Jika selectAll false, hapus semua pilihan
            $this->selectedProdi = [];
        }
    }

    public function updatedSelectedProdi()
    {
        // Jika ada dosen yang dipilih, tampilkan tombol, jika tidak, sembunyikan
        $this->showDeleteButton = count($this->selectedProdi) > 0;
    }
    public function destroySelected()
    {
        Prodi::whereIn('id_prodi', $this->selectedProdi)->delete();

        // Reset array selectedDosen setelah penghapusan
        $this->selectedProdi = [];
        $this->selectAll = false; // Reset juga selectAll

        $this->dispatch('destroyed', ['message' => 'Prodi Berhasil Dihapus']);
        $this->showDeleteButton = false;
    }

    public function destroy($id_prodi)
    {
        $prodi = Prodi::find($id_prodi);


        // Hapus data prodi
        $prodi->delete();

        // Tampilkan pesan sukses
        // session()->flash('message', 'Prodi Berhasil di Hapus');
        // session()->flash('message_type', 'error');
        $this->dispatch('destroyed', ['message' => 'Prodi Berhasil di Hapus']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $prodis = Prodi::query()
            ->where('kode_prodi', 'like', '%' . $this->search . '%')
            ->orWhere('nama_prodi', 'like', '%' . $this->search . '%')
            ->orWhere('jenjang', 'like', '%' . $this->search . '%')
            ->oldest()
            ->paginate(5);

        return view('livewire.admin.prodi.index', [
            'prodis' => $prodis,
        ]);
    }
}
