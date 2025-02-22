<?php

namespace App\Livewire\Admin\Emonev;

use App\Models\Emonev;
use App\Models\Jawaban;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $jawaban = Jawaban::join('emonev', 'jawaban.id_emonev', '=', 'emonev.id_emonev')
            ->join('dosen', 'emonev.nidn', '=', 'dosen.nidn')
            ->join('semester', 'emonev.id_semester', '=', 'semester.id_semester')
            ->join('prodi', 'dosen.kode_prodi', '=', 'prodi.kode_prodi')
            ->select(
                'dosen.nidn',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'semester.nama_semester',
                \DB::raw('SUM(jawaban.nilai) as total_nilai')
            )
            ->groupBy('dosen.nidn', 'dosen.nama_dosen', 'prodi.nama_prodi', 'semester.nama_semester')
            ->get();


        return view('livewire.admin.emonev.index', [
            'jawaban' => $jawaban
        ]);
    }
}
