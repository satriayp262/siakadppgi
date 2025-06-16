<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Kelas;
use App\Models\MataKuliah;
use Livewire\Component;

class RekapPresensi extends Component
{
    public $id_mata_kuliah;
    public $id_kelas;

    public function mount($id_mata_kuliah, $id_kelas)
    {
        $this->id_mata_kuliah = $id_mata_kuliah;
        $this->id_kelas = $id_kelas;
    }

    public function render()
    {
        $matkul = MataKuliah::findOrFail($this->id_mata_kuliah);
        $kelas = Kelas::with('semester')->findOrFail($this->id_kelas);

        return view('livewire.dosen.presensi.rekap-presensi', [
            'id_mata_kuliah' => $this->id_mata_kuliah,
            'id_kelas' => $this->id_kelas,
            'matkul' => $matkul,
            'kelas' => $kelas,
        ]);
    }
}
