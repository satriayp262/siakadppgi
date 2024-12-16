<?php

namespace App\Livewire\Mahasiswa\Emonev;

use Livewire\Component;
use App\Models\Kelas;

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
        return view('livewire.mahasiswa.emonev.show', [
            'kelas' => $kelas
        ]);
    }
}
