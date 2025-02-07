<?php

namespace App\Livewire\Dosen\Aktifitas\Kelas;

use App\Models\Kelas;
use App\Models\KRS;
use App\Models\Matakuliah;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    public $kode_mata_kuliah;
    public function render()
    {
        $mataKuliah = MataKuliah::where('nidn', Auth()->user()->nim_nidn)->where('kode_mata_kuliah', $this->kode_mata_kuliah)->first();

        $kelasEntries = KRS::where('id_mata_kuliah', $mataKuliah->id_mata_kuliah)->distinct()->pluck('id_kelas');

        $kelas = Kelas::whereIn('id_kelas', $kelasEntries )
        ->distinct()
        ->paginate(10);


        return view('livewire.dosen.aktifitas.kelas.index',[
            'kelas' => $kelas
        ]);
    }
}
