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
    public $periodes = [];
    public $nama_periode;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        if (empty($this->selectedSemester)) {
            $this->periodes = PeriodeEMonev::all();
            $aktif = false;

            foreach ($this->periodes as $periode) {
                if ($periode->isAktif()) {
                    $this->selectedSemester = $periode->id_periode;
                    $aktif = true;
                }
            }

            if (!$aktif) {
                $this->selectedSemester = PeriodeEMonev::latest()->first()->id_periode;
            }
        }

        $periode = PeriodeEMonev::with('semester')
            ->where('id_periode', $this->selectedSemester)
            ->first();

        $this->nama_periode = $periode->nama_periode;

    }


    public function render()
    {
        return view('livewire.admin.emonev.index', [
            'periode' => $this->periodes,
            'nama_periode' => $this->nama_periode,
        ]);
    }
}
