<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use App\Models\Semester;
use App\Models\Tagihan;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;


class Download extends Component
{

    public function downloadPDF()
    {
        return redirect()->route('mahasiswa.download', $this->id_tagihan);
    }


    public function render()
    {

        return view('livewire.mahasiswa.keuangan.download');
    }
}
