<?php

namespace App\Livewire\Admin\Konversi;

use App\Models\KHS;
use App\Models\KonversiNilai;
use App\Models\KRS;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class Edit extends Component
{
    use WithFileUploads;

    public $id_konversi_nilai;
    public $mahasiswa_id;
    public $krs_id;
    public $keterangan;
    public $nilai;
    public $file;
    public $nama_mahasiswa;
    public $listKRS = [];

    public function mount($id_konversi_nilai)
    {
        $f = KonversiNilai::find($id_konversi_nilai);
        if ($f) {
            $this->id_konversi_nilai = $f->id_konversi_nilai;
            $this->mahasiswa_id = $f->krs->mahasiswa->mahasiswa_id;
            $this->keterangan = $f->keterangan;
            $this->nilai = $f->nilai;
            $this->krs_id = $f->id_krs;
            $this->nama_mahasiswa = $f->krs->mahasiswa->nama;
            $this->listKRS = KRS::where('NIM', $f->krs->mahasiswa->NIM)->get();

        }
    }

    public function update()
    {
        $this->validate([
            'krs_id' => 'required',
            'keterangan' => 'required|string|max:255',
            'nilai' => 'required|integer|max:255',
            'file' => 'nullable|max:2048'
        ]);

        $komponen = KonversiNilai::findOrFail($this->id_konversi_nilai);

        // Persiapkan data untuk update
        $data = [
            'id_krs' => $this->krs_id,
            'keterangan' => $this->keterangan,
            'nilai' => $this->nilai,
        ];

        // Jika ada file TTD baru yang di-upload
        if ($this->file) {
            // Hapus tanda tangan lama jika ada
            if ($komponen->file && Storage::disk('public')->exists($komponen->file)) {
                Storage::disk('public')->delete($komponen->file);
            }

            // Simpan tanda tangan baru
            $filename = $this->file->store('file', 'public');
            $data['file'] = $filename;
        } else {

        }
        KHS::updateOrCreate([
                'id_krs' => $this->krs_id
            ], [
                'bobot' => $this->nilai
            ]);

        // Update data komponen
        $komponen->update($data);

        // Kirimkan event ke Livewire atau browser
        $this->dispatch('konversiUpdated');
    }


    public function clear($id_konversi_nilai)
    {
        $f = KonversiNilai::find($id_konversi_nilai);
        if ($f) {
            $this->id_konversi_nilai = $f->id_konversi_nilai;
            $this->keterangan = $f->keterangan;
            $this->nilai = $f->nilai;
        }
    }
    public function render()
    {
        return view('livewire.admin.konversi.edit');
    }
}
