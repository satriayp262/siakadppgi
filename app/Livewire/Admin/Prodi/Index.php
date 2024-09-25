<?php

namespace App\Livewire\Admin\Prodi;

use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use App\Models\Prodi;

#[Title(' | PRODI')]

class Index extends Component
{
    public $kode_prodi, $nama_prodi;
    public $search = '';

    #[On('ProdiCreated')]
    public function handleProdiCreated()
    {
        session()->flash('message', 'Prodi Berhasil di Tambahkan');
    }

    public function render()
    {
        $prodis = Prodi::query()
            ->where('kode_prodi', 'like', '%' . $this->search . '%')
            ->orWhere('nama_prodi', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);
        return view('livewire.admin.prodi.index', [
            'prodis' => $prodis,
        ]);
    }
}
