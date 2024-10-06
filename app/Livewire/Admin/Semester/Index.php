<?php

namespace App\Livewire\Admin\Semester;

use App\Models\Semester;
use Livewire\Component;
use Livewire\Attributes\On;


class Index extends Component
{
    #[On('semesterCreated')]

    public function handleSemester()
    {
        session()->flash('message', 'Semester Berhasil di Tambahkan');
        session()->flash('message_type', 'success');
    }


    public function render()
    {
        $semesters = Semester::query()
        ->latest()
        ->get();
        
        return view('livewire.admin.semester.index',[
            'semesters'=> $semesters
        ]);
    }
}
