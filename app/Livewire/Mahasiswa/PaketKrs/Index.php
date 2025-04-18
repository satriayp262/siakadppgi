<?php

namespace App\Livewire\Mahasiswa\PaketKrs;

use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\paketKRS;
use App\Models\Semester;
use Livewire\Component;

class Index extends Component
{
    public $mahasiswa, $paketKRS;

    public function create($data)
    {

        $paketKRSBySemester = $this->paketKRS->where('id_semester', $data);
        foreach ($paketKRSBySemester as $item) {
            KRS::create([
                'id_semester' => $data,
                'NIM' => auth()->user()->nim_nidn,
                'id_kelas' => $item->id_kelas,
                'id_mata_kuliah' => $item->id_mata_kuliah,
                'id_prodi' => $item->id_prodi
            ]);
        }
        $this->dispatch('asd', 'Pengajuan Berhasil');


    }
    public function render()
    {
        $semester = Semester::where('is_active', 1)->first();
        $this->mahasiswa = Mahasiswa::where('NIM', auth()->user()->nim_nidn)->first();
        $this->paketKRS = paketKRS::where('id_prodi', $this->mahasiswa->prodi->id_prodi)
            ->where('id_kelas', $this->mahasiswa->id_kelas)
            ->where('id_semester', $semester->id_semester)->get();
        return view('livewire.mahasiswa.paket-krs.index', [
            'paketKRS' => $this->paketKRS,
            'semester' => $semester
        ]);
    }
}
