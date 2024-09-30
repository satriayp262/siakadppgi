<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tagihan;
use App\Models\Semester;

class Index extends Component
{
    use WithPagination;


    public function render()
    {
        $semesters = Semester::all();
        $tagihans = Tagihan::query()

            ->latest()
            ->paginate(5);

        return view('livewire.staff.tagihan.index', [
            'tagihans' => $tagihans,
            'semesters' => $semesters
        ]);
    }
}
