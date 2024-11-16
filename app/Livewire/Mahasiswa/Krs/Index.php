<?php

namespace App\Livewire\Mahasiswa\Krs;

use Livewire\Component;
use App\Models\KRS;
use App\Models\Semester;

class Index extends Component
{

    public function render()
    {
        $KRS = KRS::where('NIM', auth()->user()->nim_nidn)->get();
        $semester = Semester::orderBy('nama_semester', 'desc')->get();
        return view('livewire.mahasiswa.krs.index',[
            'KRS' => $KRS,
            'semester' => $semester
        ]);
    }
}
