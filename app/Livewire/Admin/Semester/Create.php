<?php

namespace App\Livewire\Admin\Semester;

use App\Models\Semester;
use Livewire\Component;

class Create extends Component
{
    public $nama_semester;

    public function rules(){
        return [
            'nama_semester' => 'required|string|unique:semesters,nama_semester',
        ];
    }



    public function messages(){
        return [
            'nama_semester.required' => 'Semester tidak boleh kosong',
            'nama_semester.unique' => 'Semester sudah ada',
        ];
    }

    public function save(){
        $this->validate();
        
        $semester = Semester::create([
            'nama_semester' => $this->nama_semester,
        ]);

        return dd($semester);
    }

    public function render()
    {
        return view('livewire.admin.semester.create');
    }
}
