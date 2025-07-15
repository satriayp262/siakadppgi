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
    public $jawaban = [];
    public $semesters = [];
    public $id;
    public function mount($kode)
    {
        $decoded = Hashids::decode($kode);
        $this->id = $decoded[0];
        $this->loadData();
    }

    public function loadData()
    {
        if (empty($this->selectedSemester)) {
            $this->periodes = PeriodeEMonev::all();
            $aktif = false;

            foreach ($this->periodes as $periode) {
                if ($periode->isAktif()) {
                    $this->selectedSemester = $periode->nama_periode;
                    $aktif = true;
                }
            }

            if (!$aktif) {
                if ($this->periodes->isEmpty()) {
                    return $this->dispatch('warning', [
                        'message' => 'Tidak ada periode yang tersedia.',
                    ]);
                } else {
                    // If no active period is found, set to the latest period
                    $this->selectedSemester = PeriodeEMonev::latest()->first()->nama_periode;
                }
                //$this->selectedSemester = PeriodeEMonev::latest()->first()->id_periode;
            }
        }
    }
    public function render()
    {

        $matakuliah = Matakuliah::where('id_mata_kuliah', $this->id)->first();

        return view('livewire.dosen.emonev.show', [
            'periode' => PeriodeEMonev::all(),
            'Matakuliah' => $matakuliah->nama_mata_kuliah,
            'selectedSemester' => $this->selectedSemester,
            'id' => $this->id,
            'jawaban' => $this->jawaban,
            'user' => auth()->user(),
        ]);
    }
}
