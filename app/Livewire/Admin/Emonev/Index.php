<?php

namespace App\Livewire\Admin\Emonev;

use App\Models\Emonev;
use App\Models\Jawaban;
use App\Models\Pertanyaan;
use Livewire\Component;
use App\Models\Prodi;
use App\Models\Semester;
use Illuminate\Support\Facades\DB;
use App\Models\PeriodeEMonev;
use App\Livewire\Component\ChartEmonev;


class Index extends Component
{
    public $selectedSemester = '';
    public $nama_periode;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        if (empty($this->selectedSemester)) {
            $periodes = PeriodeEMonev::all();
            foreach ($periodes as $periode) {
                if ($periode->isAktif()) {
                    $this->selectedSemester = $periode->id_periode;
                } else {
                    $this->selectedSemester = $periode->latest()->first()->id_periode;
                }
            }
        }



        $x = PeriodeEMonev::with('semester')
            ->where('id_periode', $this->selectedSemester)
            ->first();

        $this->nama_periode = $x->nama_periode;

    }


    public function render()
    {
        return view('livewire.admin.emonev.index', [
            'periode' => PeriodeEMonev::all(),
            'nama_periode' => $this->nama_periode,
        ]);
    }
}
