<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use Livewire\Component;
use App\Models\Semester;

class Create extends Component
{

    public $total_tagihan;
    public $id_semester;

    public function mount($total_tagihan, $id_semester)
    {
        $this->total_tagihan = $total_tagihan;
        $this->id_semester = $id_semester;

        return [$total_tagihan, $id_semester];
    }
    public function render()
    {
        return view('livewire.mahasiswa.keuangan.create');
    }
}
