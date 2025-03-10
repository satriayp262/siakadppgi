<?php

namespace App\Livewire\Admin\Emonev;

use App\Models\Emonev;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Livewire\Component;
use App\Models\Prodi;
use App\Models\Semester;


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
        $this->loadData();
    }

    public function loadData()
    {


        $query = Jawaban::join('emonev', 'jawaban.id_emonev', '=', 'emonev.id_emonev')
            ->join('pertanyaan', 'jawaban.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
            ->join('dosen', 'emonev.nidn', '=', 'dosen.nidn')
            ->join('kelas', 'emonev.id_kelas', '=', 'kelas.id_kelas')
            ->join('matkul', 'emonev.id_mata_kuliah', '=', 'matkul.id_mata_kuliah')
            ->join('semester', 'emonev.id_semester', '=', 'semester.id_semester')
            ->join('prodi', 'matkul.kode_prodi', '=', 'prodi.kode_prodi')
            ->select(
                'dosen.nidn',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'semester.nama_semester',
                'pertanyaan.id_pertanyaan',
                'pertanyaan.nama_pertanyaan',
                'jawaban.nilai',
                'kelas.nama_kelas',
                'jawaban.created_at',
                'emonev.saran',
                'emonev.id_emonev'
            );

        if (!empty($this->selectedprodi)) {
            $query->where('prodi.nama_prodi', $this->selectedprodi);
        }

        if (!empty($this->selectedSemester)) {
            $query->where('semester.nama_semester', $this->selectedSemester);
        } else {
            $query->where('semester.nama_semester', $this->semesters[0]->nama_semester);
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

        // Eksekusi query dan simpan hasil ke variabel
        $this->jawaban = $query->groupBy('dosen.nidn', 'dosen.nama_dosen', 'prodi.nama_prodi', 'semester.nama_semester', 'pertanyaan.nama_pertanyaan', 'jawaban.nilai', 'emonev.saran', 'jawaban.created_at', 'kelas.nama_kelas', 'emonev.id_emonev', 'pertanyaan.id_pertanyaan')
            ->get();
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
            'pertanyaan' => $pertanyaan
        ]);
    }
}
