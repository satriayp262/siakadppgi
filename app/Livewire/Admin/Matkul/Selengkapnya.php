<?php

namespace App\Livewire\Admin\Matkul;

use Livewire\Component;
use App\Models\Matakuliah;

class Selengkapnya extends Component
{
    public $id_mata_kuliah;

    public function mount($id_mata_kuliah)
    {
        // Assign the ID of the Mata Kuliah passed to the component
        $this->id_mata_kuliah = $id_mata_kuliah;
    }

    public function render()
    {
        // Find the Mata Kuliah based on the ID
        $matkuls = Matakuliah::find($this->id_mata_kuliah);

        return view('livewire.admin.matkul.selengkapnya', [
            'matkuls' => $matkuls,
        ]);
    }
}
