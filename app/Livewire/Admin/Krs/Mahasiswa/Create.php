<?php

namespace App\Livewire\Admin\Krs\Mahasiswa;

use App\Models\Matakuliah;
use Livewire\Component;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\KRS;

class Create extends Component
{
    public $nim, $semester, $prodi, $matkul,$mahasiswa;
    public $id_mata_kuliah = ' ';

    public function mount()
    {
        $this->prodi = Mahasiswa::where('NIM', $this->nim)->first()->prodi;
        $this->matkul = Matakuliah::where('kode_prodi', $this->prodi->kode_prodi)->get();
        $this->mahasiswa = Mahasiswa::where('NIM',$this->nim)->first();
    }
    public function save()
    {
        $this->validate([
            'id_mata_kuliah' => 'required'
        ], [
            'id_mata_kuliah.required' => 'Pilih Mata Kuliah'
        ]);

        $duplicate = KRS::where('id_semester', $this->semester)
            ->where('NIM', $this->nim)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->first();

        if ($duplicate) {
            $this->dispatch('warningKRS', 'KRS sudah ada');
            $this->id_mata_kuliah = ' ';
            return;
        }
        $krs= KRS::create([
            'id_semester' => $this->semester,
            'NIM' => $this->nim,
            'id_kelas' => $this->mahasiswa->id_kelas,
            'id_mata_kuliah' => $this->id_mata_kuliah,
            'id_prodi' => $this->prodi->id_prodi
        ]);

        $this->dispatch('KRSUpdated');
    }

    public function render()
    {
        return view('livewire.admin.krs.mahasiswa.create', [
        ]);
    }
}
