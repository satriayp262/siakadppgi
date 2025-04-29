<?php

namespace App\Livewire\Admin\JadwalUjian;

use Livewire\Component;
use App\Models\komponen_kartu_ujian;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class KomponenEdit extends Component
{
    use WithFileUploads;

    public $id_komponen;
    public $nama;
    public $jabatan;
    public $ttd;

    public function mount($id_komponen)
    {
        $f = komponen_kartu_ujian::find($id_komponen);
        if ($f) {
            $this->id_komponen = $f->id_komponen;
            $this->nama = $f->nama;
            $this->jabatan = $f->jabatan;
        }
        return $f;
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'ttd' => 'nullable|image|max:1024' // 1MB max
        ]);

        $komponen = komponen_kartu_ujian::findOrFail($this->id_komponen);

        // Persiapkan data untuk update
        $data = [
            'nama' => $this->nama,
            'jabatan' => $this->jabatan,
        ];

        // Jika ada file TTD baru yang di-upload
        if ($this->ttd) {
            // Hapus tanda tangan lama jika ada
            if ($komponen->ttd && Storage::disk('public')->exists($komponen->ttd)) {
                Storage::disk('public')->delete($komponen->ttd);
            }

            // Simpan tanda tangan baru
            $filename = $this->ttd->store('ttd', 'public');
            $data['ttd'] = $filename;
        } else {

        }

        // Update data komponen
        $komponen->update($data);

        // Kirimkan event ke Livewire atau browser
        $this->dispatch('komponenUpdated');
    }


    public function clear($id_komponen)
    {
        $this->reset(['id_komponen', 'nama', 'jabatan', 'ttd']);
    }

    public function render()
    {
        $v = komponen_kartu_ujian::where('id_komponen', $this->id_komponen)
            ->first();
        return view('livewire.admin.jadwal-ujian.komponen-edit',[
            'v' => $v
        ]);
    }
}
