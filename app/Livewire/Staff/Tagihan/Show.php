<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tagihan;
use App\Models\Semester;
use App\Models\Prodi;
use App\Models\Mahasiswa;

class Show extends Component
{
    public $search = '';
    public function render()
    {
        $Prodis = Prodi::all();
        $mahasiswas = Mahasiswa::query()
            ->whereHas('tagihan')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(24);
        $semesters = Semester::all();
        return view('livewire.staff.tagihan.show', [
            'semesters' => $semesters,
            'mahasiswas' => $mahasiswas,
            'Prodis' => $Prodis,
        ]);
    }
}
