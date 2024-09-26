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
        session()->flash('message_type', 'success');
    }

    #[On('ProdiUpdated')]
    public function handleProdiUpdated()
    {
        session()->flash('message', 'Prodi Berhasil di Update');
        session()->flash('message_type', 'warning');
    }

    public function destroy($id_prodi)
    {
        $prodi = Prodi::find($id_prodi);


        // Hapus data prodi
        $prodi->delete();

        // Tampilkan pesan sukses
        session()->flash('message', 'Prodi Berhasil di Hapus');
        session()->flash('message_type', 'error');
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
