<?php

namespace App\Livewire\Dosen\Emonev;

use Livewire\Component;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use App\Models\Semester;
use Illuminate\Support\Facades\DB;
use Vinkla\Hashids\Facades\Hashids;


class Show extends Component
{
    public $selectedSemester = '';
    public $selectedNilai = '';
    public $selectedPertanyaan = '';
    public $jawaban = [];
    public $semesters = [];
    public $id;
    public function mount($kode)
    {
        $decoded = Hashids::decode($kode);
        $this->id = $decoded[0];
        $this->semesters = Semester::orderBy('id_semester', 'desc')->get();
        $this->loadData();
    }
    public function loadData()
    {
        // Ambil semua pertanyaan agar bisa dijadikan header
        $pertanyaan = Pertanyaan::all();
        $query = Jawaban::join('emonev', 'jawaban.id_emonev', '=', 'emonev.id_emonev')
            ->join('pertanyaan', 'jawaban.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
            ->join('kelas', 'emonev.id_kelas', '=', 'kelas.id_kelas')
            ->join('matkul', 'emonev.id_mata_kuliah', '=', 'matkul.id_mata_kuliah')
            ->join('dosen', 'matkul.nidn', '=', 'dosen.nidn')
            ->join('periode_emonev', 'emonev.nama_periode', '=', 'periode_emonev.nama_periode')
            ->select(
                'dosen.nidn',
                'dosen.nama_dosen',
                'emonev.saran',
                'periode_emonev.nama_periode',
                'matkul.nama_mata_kuliah',
            );

        if (!empty($this->selectedSemester)) {
            $findsemester = Semester::where('nama_semester', $this->selectedSemester)->first();
            $query->where('periode_emonev.id_semester', $findsemester->id_semester);

        } else {
            $query->where('periode_emonev.id_semester', $this->semesters[0]->id_semester);

        }

        $query->where('dosen.nidn', auth()->user()->nim_nidn);
        $query->where('matkul.id_mata_kuliah', $this->id);




        if ($this->selectedNilai && $this->selectedPertanyaan) {
            $query->where('pertanyaan.id_pertanyaan', $this->selectedPertanyaan);
            $query->where('jawaban.nilai', $this->selectedNilai);
            if ($query->count() == 0) {
                $this->dispatch('warning', ['message' => 'Data tidak ditemukan']);
                return $this->selectedNilai = '' && $this->selectedPertanyaan = '';
            }
        }

        // Tambahkan kolom rata-rata untuk setiap pertanyaan
        foreach ($pertanyaan as $p) {
            $query->addSelect(DB::raw(
                "
            (SELECT AVG(jwbn.nilai) 
             FROM jawaban jwbn 
             JOIN emonev em ON jwbn.id_emonev = em.id_emonev
             WHERE em.nidn = dosen.nidn 
             AND jwbn.id_pertanyaan = $p->id_pertanyaan
            ) AS `pertanyaan_$p->id_pertanyaan`"
            ));
        }

        $this->jawaban = $query->groupBy(
            'dosen.nidn',
            'dosen.nama_dosen',
            'matkul.nama_mata_kuliah',
            'emonev.saran',
            'periode_emonev.nama_periode',
        )->get();

        return $query;
    }

    public function render()
    {
        $pertanyaan = Pertanyaan::all();

        return view('livewire.dosen.emonev.show', [
            'jawaban' => $this->jawaban,
            'semesters' => $this->semesters,
            'pertanyaan' => $pertanyaan,
        ]);
    }
}
