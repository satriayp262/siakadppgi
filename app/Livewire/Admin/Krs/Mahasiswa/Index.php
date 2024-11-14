<?php

namespace App\Livewire\Admin\Krs\Mahasiswa;

use Livewire\Component;
use App\Models\Semester;

class Index extends Component
{
    public $NIM;
    public $ada = false;
    public function render()
    {
        $semester = Semester::orderBy('nama_semester', 'desc')->get();
        return view('livewire.admin.krs.mahasiswa.index',[
            'semester' => $semester,
        ]);
    }
}
