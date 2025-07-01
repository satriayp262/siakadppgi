<?php

namespace App\Livewire\Dosen\Aktifitas\Kelas;

use App\Models\Aktifitas;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class Create extends Component
{
    public $nama_aktifitas = " ", $id_kelas, $id_mata_kuliah, $catatan;

    public function save()
    {
        $lower = strtolower($this->nama_aktifitas);

        $this->validate([
            'nama_aktifitas' => [
                'required',
                function ($attribute, $value, $fail) use ($lower) {
                    $exists = Aktifitas::where('id_kelas', $this->id_kelas)
                        ->where('id_mata_kuliah', $this->id_mata_kuliah)
                        ->whereRaw('LOWER(nama_aktifitas) = ?', [$lower])
                        ->exists();

                    if ($exists) {
                        $fail("{$value} sudah ada pada kelas ini.");
                    }
                },
            ],
        ], [
            'nama_aktifitas.required' => 'Nama Aktifitas Tidak Boleh Kosong',
        ]);

        Aktifitas::create([
            'id_kelas' => $this->id_kelas,
            'id_mata_kuliah' => $this->id_mata_kuliah,
            'nama_aktifitas' => $this->nama_aktifitas,
            'catatan' => $this->catatan,
        ]);

        $this->resetExcept('id_kelas', 'id_mata_kuliah');
        $this->dispatch('aktifitasCreated');
    }





    public function render()
    {
        return view('livewire.dosen.aktifitas.kelas.create');
    }
}
