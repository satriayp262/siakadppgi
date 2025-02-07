<?php

namespace App\Livewire\Dosen\Aktifitas\Kelas;

use App\Models\Aktifitas;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class Create extends Component
{
    public $nama_aktifitas = " ", $id_kelas,$id_mata_kuliah, $catatan;

    public function save()
    {
        
        $this->validate([
            'nama_aktifitas' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (Aktifitas::where('id_kelas', $this->id_kelas)
                        ->where('nama_aktifitas', $value)
                        ->where('id_mata_kuliah', $this->id_mata_kuliah)
                        ->exists()) {
                        $fail('Aktifitas ini sudah ada');
                    }
                },
            ],
        ], [
            'nama_aktifitas.required' => 'Nama Aktifitas Tidak Boleh Kosong',
        ]);
        

        $exists = Aktifitas::where('id_kelas', $this->id_kelas)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->where('nama_aktifitas', $this->nama_aktifitas)
            ->exists();

        if (in_array($this->nama_aktifitas, ['UTS', 'UAS'])) {
            $exists = Aktifitas::where('id_kelas', $this->id_kelas)
                ->where('id_mata_kuliah', $this->id_mata_kuliah)
                ->where('nama_aktifitas', $this->nama_aktifitas)
                ->exists();

            if ($exists) {
                throw ValidationException::withMessages([
                    'nama_aktifitas' => "{$this->nama_aktifitas} sudah ada pada kelas ini.",
                ]);
            }
        }
        if ($exists) {
            throw ValidationException::withMessages([
                'nama_aktifitas' => "{$this->nama_aktifitas} sudah ada pada kelas ini.",
            ]);
        }

        Aktifitas::create([
            'id_kelas' => $this->id_kelas,
            'id_mata_kuliah' => $this->id_mata_kuliah,
            'nama_aktifitas' => $this->nama_aktifitas,
            'catatan' => $this->catatan ,
        ]);

        $this->resetExcept('id_kelas');
        $this->dispatch('aktifitasCreated');
    }



    public function render()
    {
        return view('livewire.dosen.aktifitas.kelas.create');
    }
}
