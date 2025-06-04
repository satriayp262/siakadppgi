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
        $selectedSemester = $this->selectedSemester;
        return $selectedSemester;
    }
    public function render()
    {

        return view('livewire.dosen.emonev.show', [
            'periode' => PeriodeEMonev::all(),
            'Matakuliah' => Matakuliah::where('id_mata_kuliah', $this->id)->first()->value('nama_mata_kuliah'),
            'selectedSemester' => $this->selectedSemester,
            'id' => $this->id,
            'jawaban' => $this->jawaban,
            'user' => auth()->user(),
        ]);
    }
}
