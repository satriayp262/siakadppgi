<?php

namespace App\Livewire\Admin\JadwalUjian;

use Livewire\Component;
use App\Models\komponen_kartu_ujian;
use Livewire\Attributes\On;

class Komponen extends Component
{
    #[On('komponenUpdated')]
    public function z()
    {
        $this->dispatch('created', ['message' => 'Komponen Edited Successfully']);
    }

    public function render()
    {
        $komponen = komponen_kartu_ujian::get();

        return view('livewire.admin.jadwal-ujian.komponen', [
            'komponen' => $komponen
        ]);
    }
}
