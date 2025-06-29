<?php

namespace App\Livewire\Admin\Konversi;

use App\Models\KHS;
use App\Models\KonversiNilai;
use App\Models\KRS;
use App\Models\Mahasiswa;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;
    public $mahasiswa_id;
    public $krs_id;
    public $keterangan;
    public $nilai;
    public $file;
    public $listKRS = [];

    public function updatedMahasiswaId($value)
    {
        $this->listKRS = KRS::where('NIM', $value)->get();
        $this->krs_id = null;
    }
    public function save()
    {
        $this->validate([
            'krs_id' => 'required',
            'keterangan' => 'required|string|max:255',
            'nilai' => 'required|integer|max:255',
            'file' => 'nullable|max:2048'
        ]);

        $data = [
            'id_krs' => $this->krs_id,
            'keterangan' => $this->keterangan,
            'nilai' => $this->nilai,
        ];

        if ($this->file) {
            $filename = $this->file->store('file', 'public');
            $data['file'] = $filename;
        }
        KHS::updateOrCreate([
            'id_krs' => $this->krs_id
        ], [
            'bobot' => $this->nilai
        ]);
        // Create new record
        KonversiNilai::create($data);

        // Dispatch event to notify frontend
        $this->dispatch('konversiCreated');
    }

    public function render()
    {
        return view('livewire.admin.konversi.create', [
            'mahasiswaList' => Mahasiswa::select('NIM', 'nama')->get(),
        ]);
    }
}
