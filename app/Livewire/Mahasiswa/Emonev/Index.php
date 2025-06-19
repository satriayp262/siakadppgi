<?php

namespace App\Livewire\Mahasiswa\Emonev;

use App\Models\Dosen;
use App\Models\KRS;
use App\Models\MahasiswaEmonev;
use App\Models\Matakuliah;
use App\Models\PeriodeEMonev;
use App\Models\Semester;
use Livewire\Component;
use App\Models\Kelas;
use App\Models\Mahasiswa;

class Index extends Component
{
    public $NIM;

    public $krs;

    public $listsemester;

    public $id_kelas;

    public $periode;

    public $id_mata_kuliah;

    public $id_semester;

    public $nama_semester;

    public $selectedSemester;

    public $mahasiswa;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $user = auth()->user();
        $mahasiswa = Mahasiswa::where('NIM', $user->nim_nidn)->first();
        $krs = KRS::where('NIM', $mahasiswa->NIM)->get();

        $semesterIds = [];
        foreach ($krs as $k) {
            $semesterIds[] = $k->id_semester;

        }

        $this->listsemester = Semester::whereIn('id_semester', $semesterIds)->get();

        if ($this->selectedSemester == '') {
            $periode = PeriodeEMonev::with('semester')->get();
            foreach ($periode as $p) {
                if ($p->isAktif()) {
                    $this->selectedSemester = $p->semester->nama_semester;

                }
            }
        }

        $this->findsemester = Semester::where('nama_semester', $this->selectedSemester)->first();
        $this->krs = $krs->where('id_semester', $this->findsemester->id_semester)->values();
        $this->periode = PeriodeEMonev::where('id_semester', $this->findsemester->id_semester)->get();
        foreach ($this->krs as $k) {
            $this->id_kelas = $k->id_kelas;
        }
        $this->kelas = Kelas::where('id_kelas', $this->id_kelas)->first();
    }


    public function render()
    {
        return view('livewire.mahasiswa.emonev.index', [
            'krs' => $this->krs,
            'semester1' => $this->findsemester ?? null,
            'kelas' => $this->kelas ?? null,
            'semesters' => $this->listsemester,
            'periode1' => $this->periode[0] ?? null,
            'periode2' => $this->periode[1] ?? null,
        ]);
    }
}