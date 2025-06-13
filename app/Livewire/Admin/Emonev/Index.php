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


class Index extends Component
{
    public $selectedSemester = '';
    public $x;

    public function loadData()
    {
        if ($this->selectedSemester == '') {
            $this->dispatch('warning', ['message' => 'Harap Pilih Periode']);
            return;
        }

        $x = PeriodeEMonev::with('semester')
            ->where('id_periode', $this->selectedSemester)
            ->first();

        $this->x = $x->nama_periode;

    }

    public function render()
    {


        return view('livewire.admin.emonev.index', [
            'periode' => PeriodeEMonev::all(),
            'x' => $this->x,
        ]);
    }
}
