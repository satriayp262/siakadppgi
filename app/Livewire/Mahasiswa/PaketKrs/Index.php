<?php

namespace App\Livewire\Mahasiswa\PaketKrs;

use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\paketKRS;
use App\Models\Semester;
use Livewire\Component;

class Index extends Component
{
    public $semester,$krsThisSemester,$mahasiswa, $paketKRS;

    public function create($data)
    {

        $paketKRSBySemester = $this->paketKRS->where('id_semester', $data);
        $rows = [];
        foreach ($paketKRSBySemester as $item) {
            $rows[] = [
                'id_semester' => $data,
                'NIM' => $this->mahasiswa->NIM,
                'id_kelas' => $item->id_kelas,
                'id_mata_kuliah' => $item->id_mata_kuliah,
                'id_prodi' => $item->id_prodi,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        KRS::insert($rows);

        $this->dispatch('asd', 'Pengajuan Berhasil');


    }
    public function mount()
    {
        $this->semester = Semester::where('is_active', 1)->first();
        $this->mahasiswa = Mahasiswa::where('NIM', auth()->user()->nim_nidn)->first();
        $this->paketKRS = paketKRS::where('id_prodi', $this->mahasiswa->prodi->id_prodi)
            ->where('id_kelas', $this->mahasiswa->id_kelas)
            ->where('id_semester', $this->semester->id_semester)->get();
        $this->krsThisSemester = KRS::where('id_semester', $this->semester->id_semester)
            ->where('NIM', auth()->user()->nim_nidn)
            ->exists();
    }
    public function render()
    {
        return view('livewire.mahasiswa.paket-krs.index', [
        ]);
    }
}
