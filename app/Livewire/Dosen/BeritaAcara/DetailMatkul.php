<?php

namespace App\Livewire\Dosen\BeritaAcara;

use Livewire\Component;
use App\Models\Matakuliah;

class DetailMatkul extends Component
{
    public $matkul;

    public function mount(Matakuliah $matkul)
    {
        $this->matkul = $matkul;
    }

    public function render()
    {
        return view('livewire.dosen.berita_acara.detail-matkul', [
            'matkul' => $this->matkul,
        ]);
    }
}

