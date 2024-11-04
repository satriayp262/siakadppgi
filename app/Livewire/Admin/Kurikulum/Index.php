<?php

namespace App\Livewire\Admin\Kurikulum;

use Livewire\Component;
use App\Models\Kurikulum;
use App\Models\Prodi;
use App\Models\Semester;

class Index extends Component
{

    public function render()
    {
        $kurikulums = Kurikulum::all();
        $prodis = Prodi::all();
        $semesters = Semester::all();

        return view('livewire.admin.kurikulum.index', [
            'kurikulums' => $kurikulums,
            'prodis' => $prodis,
            'semesters' => $semesters
        ]);
    }
}
