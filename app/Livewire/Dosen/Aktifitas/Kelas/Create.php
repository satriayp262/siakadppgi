<?php

namespace App\Livewire\Dosen\Aktifitas\Kelas;

use App\Models\Aktifitas;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class Create extends Component
{
    public $nama_aktifitas =" ", $id_kelas, $catatan;

    public function save()
    {
        $this->validate(['nama_aktifitas' => 'required'],[
            'nama_aktifitas.required' => 'Nama Aktifitas Tidak Boleh Kosong'
        ]);
        if ($this->nama_aktifitas == 'Tugas') {
            $existingTugas = Aktifitas::where('id_kelas', $this->id_kelas)
                                      ->where('nama_aktifitas', 'like', 'Tugas%')
                                      ->pluck('nama_aktifitas');
    
            $tugasNumbers = $existingTugas->map(function ($tugas) {
                return (int)filter_var($tugas, FILTER_SANITIZE_NUMBER_INT);
            })->filter()->toArray();
    
            $nextTugasNumber = $tugasNumbers ? max($tugasNumbers) + 1 : 1;
            $this->nama_aktifitas = 'Tugas ' . $nextTugasNumber;
        } elseif (in_array($this->nama_aktifitas, ['UTS', 'UAS'])) {
            $exists = Aktifitas::where('id_kelas', $this->id_kelas)
                               ->where('nama_aktifitas', $this->nama_aktifitas)
                               ->exists();
    
            if ($exists) {
                throw ValidationException::withMessages([
                    'nama_aktifitas' => "{$this->nama_aktifitas} sudah ada pada kelas ini.",
                ]);
            }
        }

        Aktifitas::create([
            'id_kelas' => $this->id_kelas,
            'nama_aktifitas' => $this->nama_aktifitas,
            'catatan' => $this->catatan ?? $this->nama_aktifitas,
        ]);
        $this->reset();

        $this->nama_aktifitas = "Tugas";

        $this->dispatch('aktifitasCreated');



    }
    

    public function render()
    {
        return view('livewire.dosen.aktifitas.kelas.create');
    }
}
