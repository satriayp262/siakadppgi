<?php

namespace App\Livewire\Dosen\Bobot\Kelas;

use App\Models\KRS;
use App\Models\Mahasiswa;
use DB;
use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Livewire\Attributes\On;

class Index extends Component
{
    public $kode_mata_kuliah, $url;

    #[On('kelasUpdated')]
    public function handelKelasUpdated()
    {

        $this->dispatch('BobotUpdate', ['message' => 'Kelas Berhasil Diupdate', 'link' => $this->url]);

    }

    public function render()
    {
        $this->url = request()->url();

        // matkul berdasar kode dan dosen
        $mataKuliah = MataKuliah::where('nidn', Auth()->user()->nim_nidn)->where('kode_mata_kuliah', $this->kode_mata_kuliah)->first();

        //cari seluruh krs pada prodi ini dan matkul ini
        $krsEntries = KRS::where('id_mata_kuliah', $mataKuliah->id_mata_kuliah)->where('id_prodi',$mataKuliah->prodi->id_prodi)->pluck('NIM');

        //ambil seluruh kelas berdasar array nim
        $kelas = Kelas::whereIn('id_kelas', function ($query) use ($krsEntries) {
            $query->select('id_kelas')
                ->from('mahasiswa')
                ->whereIn('NIM', $krsEntries);
        })
        ->with(['prodi', 'semester'])
        ->distinct()
        ->get();
        

        // dd($kelas);
        return view('livewire.dosen.bobot.kelas.index', [
            'kelas' => $kelas
        ]);
    }
}
