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
    public $query = [];
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
            ->join('periode_emonev', 'emonev.nama_periode', '=', 'periode_emonev.nama_periode')
            ->join('prodi', 'matkul.kode_prodi', '=', 'prodi.kode_prodi')
            ->select(
                'dosen.nidn',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'periode_emonev.nama_periode',
                'matkul.nama_mata_kuliah',
            );

        if (!empty($this->selectedprodi)) {
            $query->where('prodi.nama_prodi', $this->selectedprodi);
        }

        if (!empty($this->selectedSemester)) {
            $findsemester = Semester::where('nama_semester', $this->selectedSemester)->first();
            $query->where('periode_emonev.id_semester', $findsemester->id_semester);

        } else {
            // $query->where('periode_emonev.id_semester', $this->semesters[0]->id_semester);
            $query->where('periode_emonev.id_semester', '5');
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
            'periode_emonev.nama_periode',
        )->get();


        return $query;
    }

    public function download()
    {
        $this->loadData();

        session()->put('jawaban', $this->jawaban);

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
