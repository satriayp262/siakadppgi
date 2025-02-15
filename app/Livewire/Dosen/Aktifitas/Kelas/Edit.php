<?php

namespace App\Livewire\Dosen\Aktifitas\Kelas;

use App\Models\Aktifitas;
use App\Models\Kelas;
use App\Models\Matakuliah;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Edit extends Component
{
    public $id_aktifitas;
    public $id_mata_kuliah;
    public $kode_mata_kuliah;
    public $nama_aktifitas = " ", $id_kelas,$nama_kelas,$catatan;
    public function mount()
    {
        $aktifitas = Aktifitas::find($this->id_aktifitas);
        $this->nama_aktifitas = $aktifitas->nama_aktifitas;
        $this->catatan = $aktifitas->catatan;

    }
    public function update()
    {
        $this->validate([
            'nama_aktifitas' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (
                        Aktifitas::where('id_kelas', $this->id_kelas)
                            ->where('nama_aktifitas', $value)
                            ->where('id_mata_kuliah', $this->id_mata_kuliah)
                            ->exists()
                    ) {
                        $fail('Aktifitas ini sudah ada');
                    }
                },
            ],
        ], [
            'nama_aktifitas.required' => 'Nama Aktifitas Tidak Boleh Kosong',
        ]);
        if ($this->nama_aktifitas == "uas") {
            $this->nama_aktifitas = "UAS";
        } elseif ($this->nama_aktifitas == "uts") {
            $this->nama_aktifitas = "UTS";
        }
        if (in_array($this->nama_aktifitas, ['UTS', 'UAS'])) {
            $exists = Aktifitas::where('id_kelas', $this->id_kelas)
                ->where('id_mata_kuliah', $this->id_mata_kuliah)
                ->where('nama_aktifitas', $this->nama_aktifitas)
                ->where('id_aktifitas', '!=', $this->id_aktifitas)
                ->exists();
            if ($exists) {
                throw ValidationException::withMessages([
                    'nama_aktifitas' => "{$this->nama_aktifitas} sudah ada pada kelas ini.",
                ]);
            }
        }
        $aktifitas = Aktifitas::find($this->id_aktifitas);
        if ($aktifitas) {
            $aktifitas->update([
                'id_kelas' => $this->id_kelas,
                'id_mata_kuliah' => $this->id_mata_kuliah,                
                'nama_aktifitas' => $this->nama_aktifitas,
                'catatan' => $this->catatan,
            ]);
        } else {
            throw new \Exception('Aktifitas record not found.');
        }
        $this->dispatch('aktifitasUpdated');
    }
    public function render()
    {
        return view('livewire.dosen.aktifitas.kelas.edit');
    }
}
