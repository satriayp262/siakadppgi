<?php

namespace App\Livewire\Dosen\Bobot\Kelas;

use App\Models\KRS;
use App\Models\Mahasiswa;
use DB;
use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class Index extends Component
{
    public $kode_mata_kuliah, $url,$nidn;

    #[On('kelasUpdated')]
    public function handelKelasUpdated()
    {

        $this->dispatch('BobotUpdate', ['message' => 'Kelas Berhasil Diupdate', 'link' => $this->url]);

    }

    public function render()
    {
        $this->url = request()->url();

        $mataKuliah = MataKuliah::where('nidn', $this->nidn)->where('kode_mata_kuliah', $this->kode_mata_kuliah)->first();

        $kelasEntries = KRS::where('id_mata_kuliah', $mataKuliah->id_mata_kuliah)->distinct()->pluck('id_kelas');

        $kelas = Kelas::whereIn('id_kelas', $kelasEntries )
        ->distinct()
        ->paginate(10);
        
        return view('livewire.dosen.bobot.kelas.index', [
            'kelas' => $kelas
        ]);
    }
}
