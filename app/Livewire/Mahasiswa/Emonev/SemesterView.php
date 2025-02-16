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

        $semestermulai = Semester::where('id_semester', $mahasiswa->mulai_semester)->first();

        $mahasiswajenjang = $mahasiswa->prodi->jenjang;

        if ($mahasiswajenjang == 'D3') {
            $totalsemester = 6;
        } elseif ($mahasiswajenjang == 'S1') {
            $totalsemester = 8;
        } else {
            return 'jenjang tidak terdaftar';
        }

        return view('livewire.mahasiswa.emonev.semester-view', [
            'mahasiswa' => $mahasiswa,
            'semester' => $semester,
            'semestermulai' => $semestermulai,
            'totalsemester' => $totalsemester

        ]);
    }
}
