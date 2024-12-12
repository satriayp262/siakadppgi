<?php

namespace App\Livewire\Admin\PresensiMahasiswa;

use App\Models\Mahasiswa;
use App\Models\Presensi;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        $dataMahasiswa = Mahasiswa::withCount([
            'presensi as hadir_count' => function ($query) {
                $query->where('keterangan', 'Hadir');
            },
            'presensi as ijin_count' => function ($query) {
                $query->where('keterangan', 'Ijin');
            },
            'presensi as sakit_count' => function ($query) {
                $query->where('keterangan', 'Sakit');
            },
        ])->paginate(10);

        return view('livewire.admin.presensi-mahasiswa.index', [
            'dataMahasiswa' => $dataMahasiswa,
        ]);
    }
}
