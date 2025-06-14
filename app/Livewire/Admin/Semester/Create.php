<?php

namespace App\Livewire\Admin\Semester;

use App\Models\Semester;
use Livewire\Component;

class Create extends Component
{
    public $nama_semester;

    public function rules()
    {
        return [
            'nama_semester' => 'required|string|unique:semester,nama_semester',
        ];
    }

    public function messages()
    {
        return [
            'nama_semester.required' => 'Semester tidak boleh kosong',
            'nama_semester.unique' => 'Semester sudah ada',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        $validatedData['nama_semester'] = (string) $validatedData['nama_semester'];

        // Save the semester with '1' appended
        $semester1 = Semester::create([
            'nama_semester' => $validatedData['nama_semester'] . '1',
            'bulan_mulai' => (int) ($validatedData['nama_semester'] - 1) . '-09',
            'bulan_selesai' => (int) $validatedData['nama_semester'] . '-01',
        ]);

        // Save the semester with '2' appended
        $semester2 = Semester::create([
            'nama_semester' => $validatedData['nama_semester'] . '2',
            'bulan_mulai' => (int) $validatedData['nama_semester'] . '-02',
            'bulan_selesai' => (int) $validatedData['nama_semester'] . '-07',
        ]);
        $this->dispatch('semesterCreated');
        $this->reset();
        return [$semester1, $semester2];
    }

    public function render()
    {
        return view('livewire.admin.semester.create');
    }
}
