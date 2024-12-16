<?php

namespace App\Livewire\Khs;

use App\Models\Dosen;
use App\Models\KHS;
use App\Models\Mahasiswa;
use App\Models\Prodi;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        if (auth()->user()->role == 'sad') {
            $this->kode_prodi = Dosen::where('nidn', auth()->user()->nim_nidn)->first()->kode_prodi;
            $Mahasiswa = Mahasiswa::where('kode_prodi',  $this->kode_prodi )->paginate(20);
        }
        // if (auth()->user()->role == 'admin') {
            $Mahasiswa = Mahasiswa::join('semester', 'mahasiswa.mulai_semester', '=', 'semester.id_semester')
                ->orderBy('semester.nama_semester', 'desc')
                ->select('mahasiswa.*')
                ->paginate(20);

        // }
        return view('livewire.khs.index', [
            'mahasiswa' => $Mahasiswa
        ]);
    }
}
