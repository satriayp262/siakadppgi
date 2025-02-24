<?php

namespace App\Livewire\Admin\Emonev;

use App\Models\Emonev;
use App\Models\Jawaban;
use Livewire\Component;
use App\Models\Prodi;
use App\Models\Semester;


class Index extends Component
{
    public $selectedSemester = '';
    public $selectedprodi = '';
    public $jawaban = [];
    public $semesters = [];
    public $prodis = [];


    public function mount()
    {
        $this->semesters = Semester::orderBy('id_semester', 'desc')->get();
        $this->prodis = Prodi::latest()->get();
        $this->loadData();
    }

    public function loadData()
    {

        $query = Jawaban::join('emonev', 'jawaban.id_emonev', '=', 'emonev.id_emonev')
            ->join('dosen', 'emonev.nidn', '=', 'dosen.nidn')
            ->join('semester', 'emonev.id_semester', '=', 'semester.id_semester')
            ->join('prodi', 'dosen.kode_prodi', '=', 'prodi.kode_prodi')
            ->select(
                'dosen.nidn',
                'dosen.nama_dosen',
                'prodi.nama_prodi',
                'semester.nama_semester',
                \DB::raw('SUM(jawaban.nilai) as total_nilai')
            );

        if (!empty($this->selectedprodi)) {
            $query->where('prodi.nama_prodi', $this->selectedprodi);

        }


        if (!empty($this->selectedSemester)) {
            $query->where('semester.nama_semester', $this->selectedSemester);
        }

        // Eksekusi query dan simpan hasil ke variabel
        $this->jawaban = $query->groupBy('dosen.nidn', 'dosen.nama_dosen', 'prodi.nama_prodi', 'semester.nama_semester')
            ->get();

    }

    public function download()
    {
        $this->loadData();

        session()->put('jawaban', $this->jawaban->toArray());

        return redirect()->route('admin.emonev.download');
    }

    public function render()
    {

        return view('livewire.admin.emonev.index', [
            'jawaban' => $this->jawaban,
            'semesters' => $this->semesters,
            'Prodis' => $this->prodis,
        ]);
    }
}
