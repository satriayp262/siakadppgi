<?php

namespace App\Livewire\Dosen\Emonev;

use App\Models\Matakuliah;
use Livewire\Component;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Support\Facades\DB;


class Index extends Component
{




    public function render()
    {
        $matkul = Matakuliah::where('nidn', auth()->user()->nim_nidn)->get();

        return view('livewire.dosen.emonev.index', [
            'matkul' => $matkul,
        ]);
    }
}
