<?php

namespace App\Livewire\Mahasiswa\Emonev;

use Livewire\Component;
use App\Models\Kelas;
use App\Models\Pertanyaan;

class Show extends Component
{
    public $id_kelas;
    public function mount($id_kelas)
    {
        $this->id_kelas = $id_kelas;
    }
    public function render()
    {
        $kelas = Kelas::where('id_kelas', $this->id_kelas)->first();
        $pertanyaan = Pertanyaan::query()->get();
        return view('livewire.mahasiswa.emonev.show', [
            'kelas' => $kelas,
            'pertanyaans' => $pertanyaan
        ]);
    }
}
