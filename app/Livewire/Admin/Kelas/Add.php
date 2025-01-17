<?php

namespace App\Livewire\Admin\Kelas;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Livewire\Component;

class Add extends Component
{

    public function mount($id_kelas)
    {
        $this->id_kelas = $id_kelas;
        $this->mahasiswa = Mahasiswa::where('id_kelas', $this->id_kelas)->get();
    }
    public function render()
    {
        return view('livewire.admin.kelas.add', [
            'mahasiswa' => $this->mahasiswa
        ]);
    }
}
