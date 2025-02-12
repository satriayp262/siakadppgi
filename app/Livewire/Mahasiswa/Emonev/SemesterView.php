<?php

namespace App\Livewire\Mahasiswa\Emonev;

use Livewire\Component;
use App\Models\Mahasiswa;
use App\Models\Semester;

class SemesterView extends Component
{
    public function render()
    {

        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('NIM', $user->nim_nidn)
            ->first();

        $semester = Semester::all();


        //dd($mahasiswa);
        return view('livewire.mahasiswa.emonev.semester-view', [
            'mahasiswa' => $mahasiswa,
            'semester' => $semester

        ]);
    }
}
