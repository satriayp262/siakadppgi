<?php

namespace App\Livewire\Admin\Jadwal;

use Livewire\Component;
use App\Models\Semester;

class Create extends Component
{
    public function render()
    {
        $semesters = Semester::orderBy('created_at', 'desc')->take(12)->get();
        return view('livewire.admin.jadwal.create', [
            'semesters' => $semesters
        ]);
    }
}
