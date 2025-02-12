<?php

namespace App\Livewire\Mahasiswa\Emonev;

use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Pertanyaan;

class Show extends Component
{
    public $id_kelas;



    public function mount($id_mata_kuliah)
    {
        $this->id = $id_mata_kuliah;
    }



    public function save()
    {
        $this->validate([
            'jawaban' => 'required|in:6,7,8,9,10',
        ]);

        $emonev = Emonev::create([
            'jawaban' => $this->jawaban,
            'id_mata_kuliah' => $this->id,
            'id_user' => auth()->id(),
        ]);



    }
    public function render()
    {
        $matkul = Matakuliah::query()->find($this->id);
        $pertanyaan = Pertanyaan::query()->get();
        return view('livewire.mahasiswa.emonev.show', [
            'matkul' => $matkul,
            'pertanyaans' => $pertanyaan,

        ]);
    }
}
