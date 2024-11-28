<?php

namespace App\Livewire\Admin\Krs\Mahasiswa;

use Livewire\Component;
use App\Models\Kelas;
use App\Models\Mahasiswa;
use App\Models\KRS;

class Create extends Component
{
    public $nim, $semester, $prodi;
    public $id_kelas = ' ';

    public function mount()
    {
        $this->prodi = Mahasiswa::where('NIM', $this->nim)->first()->prodi;
    }
    public function save()
    {
        $this->validate([
            'id_kelas' => 'required'
        ]);

        $duplicate = KRS::where('id_semester', $this->semester)
            ->where('NIM', $this->nim)
            ->where('id_kelas', $this->id_kelas)
            ->exists();

        if ($duplicate) {
            $this->dispatch('warningKRS', 'KRS sudah ada');
            $this->id_kelas = ' ';
            return;
        }
        KRS::create([
            'id_semester' => $this->semester,
            'NIM' => $this->nim,
            'id_kelas' => $this->id_kelas,
            'id_mata_kuliah' => kelas::where('id_kelas', $this->id_kelas)->first()->id_mata_kuliah,
            'id_prodi' => $this->prodi->id_prodi
        ]);

        $this->dispatch('KRSUpdated');
    }

    public function render()
    {
        $kelas = Kelas::where('kode_prodi', $this->prodi->kode_prodi)->where('id_semester', $this->semester)->get();
        return view('livewire.admin.krs.mahasiswa.create', [
            'kelas' => $kelas
        ]);
    }
}
