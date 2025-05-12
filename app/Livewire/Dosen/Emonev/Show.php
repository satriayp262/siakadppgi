<?php

namespace App\Livewire\Dosen\Emonev;

use App\Models\Matakuliah;
use App\Models\PeriodeEMonev;
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

    }

    public function loadData()
    {
        $user = auth()->user();
        $query = Jawaban::join('emonev', 'jawaban.id_emonev', '=', 'emonev.id_emonev')
            ->join('pertanyaan', 'jawaban.id_pertanyaan', '=', 'pertanyaan.id_pertanyaan')
            ->join('periode_emonev', 'emonev.nama_periode', '=', 'periode_emonev.nama_periode')
            ->join('kelas', 'emonev.id_kelas', '=', 'kelas.id_kelas')
            ->join('matkul', 'emonev.id_mata_kuliah', '=', 'matkul.id_mata_kuliah')
            ->join('dosen', 'matkul.nidn', '=', 'dosen.nidn')
            ->select(
                'dosen.nidn',
                'dosen.nama_dosen',
                'emonev.saran',
                'periode_emonev.nama_periode',
                'matkul.nama_mata_kuliah',
            );


        $query->where('dosen.nidn', $user->nim_nidn);

        $query->where('emonev.nama_periode', $this->selectedSemester);
        $query->where('emonev.id_mata_kuliah', $this->id);

        $pertanyaan = Pertanyaan::all();

        foreach ($pertanyaan as $p) {
            $query->addSelect(DB::raw("
            MAX(CASE WHEN jawaban.id_pertanyaan = {$p->id_pertanyaan} THEN jawaban.nilai END) AS pertanyaan_{$p->id_pertanyaan}
        "));
        }

        $this->jawaban = $query->groupBy(
            'dosen.nidn',
            'dosen.nama_dosen',
            'matkul.nama_mata_kuliah',
            'emonev.saran',
            'periode_emonev.nama_periode',
        )->get();
    }
    public function render()
    {

        return view('livewire.dosen.emonev.show', [
            'periode' => PeriodeEMonev::all(),
            'Matakuliah' => Matakuliah::where('id_mata_kuliah', $this->id)->first()->value('nama_mata_kuliah'),
            'selectedSemester' => $this->selectedSemester,
            'id' => $this->id,
            'jawaban' => $this->jawaban,
        ]);
    }
}
