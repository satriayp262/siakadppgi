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

    public $id_kelas;

    public $id_mata_kuliah;

    public $id_semester;

    public $nama_semester;

    public $selectedSemester;

    public $mahasiswa;

    public function mount()
    {
        $user = auth()->user();
        $this->mahasiswa = Mahasiswa::where('NIM', $user->nim_nidn)->first();
        $this->loadData();
    }

    public function loadData()
    {

        $query = KRS::where('NIM', $this->mahasiswa->NIM);

        if (!empty($this->selectedSemester)) {

            $findsemester = Semester::where('nama_semester', $this->selectedSemester)->first();
            $query->where('id_semester', $findsemester->id_semester);

        } else {
            $query->where('id_semester', $this->mahasiswa->mulai_semester);
        }
        $this->krs = $query->get();
    }


    public function render()
    {
        $semestermulai = Semester::where('id_semester', $this->mahasiswa->mulai_semester)->first();

        $mahasiswajenjang = $this->mahasiswa->prodi->jenjang;

        if ($mahasiswajenjang == 'D3') {
            $totalsemester = 6;
        } elseif ($mahasiswajenjang == 'S1') {
            $totalsemester = 8;
        } else {
            return 'jenjang tidak terdaftar';
        }

        $items = [];
        for ($i = $semestermulai->id_semester; $i < $semestermulai->id_semester + $totalsemester; $i++) {
            $items[] = Semester::where('id_semester', $i)->get();
        }

        foreach ($this->krs as $k) {
            $kelas = Kelas::where('id_kelas', $k->id_kelas)->first();
        }

        $findsemester = Semester::where('nama_semester', $this->selectedSemester)->first();

        $nama_semester = Semester::where('id_semester', $this->mahasiswa->mulai_semester)->first();

        if ($this->selectedSemester) {
            $periode = PeriodeEMonev::where('id_semester', $findsemester)->get();
        } else {
            $periode = PeriodeEMonev::where('id_semester', $this->mahasiswa->mulai_semester)->get();
        }



        return view('livewire.mahasiswa.emonev.index', [
            'krs' => $this->krs,
            'semester1' => $findsemester ?? $nama_semester,
            'k' => $kelas ?? null,
            'semesters' => $items,
            'semestermulai' => $semestermulai,
            'totalsemester' => $totalsemester,
            'periode1' => $periode[0] ?? null,
            'periode2' => $periode[1] ?? null,
        ]);
    }
}