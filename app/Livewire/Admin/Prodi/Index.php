<?php

namespace App\Livewire\Admin\Prodi;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Models\Prodi;

#[Title(' | PRODI')]

class Index extends Component
{
    public $search = '';
    use WithPagination;

    #[On('ProdiCreated')]
    public function handleProdiCreated()
    {
        session()->flash('message', 'Prodi Berhasil di Tambahkan');
    }

    #[On('ProdiUpdated')]
    public function handleProdiUpdated()
    {
        session()->flash('message', 'Prodi Berhasil di Update');
    }

    public function destroy($id_prodi)
    {
        $prodi = Prodi::find($id_prodi);

        // Hapus data prodi
        $prodi->delete();

        // Tampilkan pesan sukses
        session()->flash('message', 'Prodi Berhasil di Hapus');
    }

    public function render()
    {
        $prodis = Prodi::query()
            ->where('kode_prodi', 'like', '%' . $this->search . '%')
            ->orWhere('nama_prodi', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);

        return view('livewire.admin.prodi.index', [
            'prodis' => $prodis,
        ]);
    }
}
