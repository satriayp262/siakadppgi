<?php

namespace App\Livewire\Admin\Emonev;

use App\Models\Emonev;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Livewire\Component;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Support\Facades\DB;


class Index extends Component
{
    public $selectedSemester = '';
    public $selectedprodi = '';
    public $selectedNilai = '';
    public $selectedPertanyaan = '';
    public $selectedDosen = '';
    public $jawaban = [];
    public $semesters = [];
    public $prodis = [];



    public function mount()
    {
        $this->semesters = Semester::orderBy('id_semester', 'desc')->get();
        $this->prodis = Prodi::latest()->get();
        $this->loadData();
    }

    public function setValues($nilai, $pertanyaanId)
    {
        $this->selectedNilai = $nilai;
        $this->selectedPertanyaan = $pertanyaanId;

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
            ->join('semester', 'emonev.id_semester', '=', 'semester.id_semester')
            ->join('prodi', 'matkul.kode_prodi', '=', 'prodi.kode_prodi')
            ->select(
                'dosen.nidn',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'semester.nama_semester',
                'pertanyaan.id_pertanyaan',
                'pertanyaan.nama_pertanyaan',
                'matkul.nama_mata_kuliah',
                'jawaban.created_at',
                'emonev.saran',
                'emonev.id_emonev',

            );

        if (!empty($this->selectedprodi)) {
            $query->where('prodi.nama_prodi', $this->selectedprodi);
        }

        if (!empty($this->selectedSemester)) {
            $query->where('semester.nama_semester', $this->selectedSemester);

        } else {
            $query->where('semester.nama_semester', $this->semesters[0]->nama_semester);
            // $query->where('semester.nama_semester', '20221')
            //     ->where('dosen.nidn', '1111111111');
        }

        if ($this->selectedNilai && $this->selectedPertanyaan) {
            $query->where('pertanyaan.id_pertanyaan', $this->selectedPertanyaan);
            $query->where('jawaban.nilai', $this->selectedNilai);
            if ($query->count() == 0) {
                $this->dispatch('warning', ['message' => 'Data tidak ditemukan']);
                return $this->selectedNilai = '' && $this->selectedPertanyaan = '';
            }
        }

        if ($this->selectedDosen) {
            $query->where('dosen.nidn', $this->selectedDosen);
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
            'prodi.nama_prodi',
            'semester.nama_semester',
            'emonev.id_emonev',
            'pertanyaan.id_pertanyaan',
            'pertanyaan.nama_pertanyaan',
            'emonev.saran',
            'jawaban.created_at'
        )->get();


        return $query;
    }

    public function averagescore()
    {
        // Calculate average score for each pertanyaan
        $this->averageScores = $this->jawaban->groupBy('id_pertanyaan')->map(function ($group) {
            return $group->avg('nilai');
        });

        $this->averageScores = $this->averageScores->map(function ($score) {
            return round($score);
        });


        return $this->averageScores;
    }


    public function download()
    {
        $this->loadData();

        session()->put('jawaban', $this->jawaban->toArray());

        dd(session()->get('jawaban'));

        return redirect()->route('admin.emonev.download');
    }

    public function render()
    {

        $pertanyaan = Pertanyaan::all();
        return view('livewire.admin.emonev.index', [
            'jawaban' => $this->jawaban,
            'semesters' => $this->semesters,
            'Prodis' => $this->prodis,
            'pertanyaan' => $pertanyaan,

        ]);
    }
}
