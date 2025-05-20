<?php

namespace App\Livewire\Admin\Ttd;

use App\Models\ttd;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
class Edit extends Component
{
    use WithFileUploads;

    public $id_ttd;
    public $nama;
    public $jabatan;
    public $ttd;

    public function mount($id_ttd)
    {
        $f = ttd::find($id_ttd);
        if ($f) {
            $this->id_ttd = $f->id_ttd;
            $this->nama = $f->nama;
            $this->jabatan = $f->jabatan;
        }
    }

    public function update()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'ttd' => 'nullable|image|max:1024' // 1MB max
        ]);

        $komponen = ttd::findOrFail($this->id_ttd);

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
        $this->dispatch('ttdUpdated');
    }


    public function clear($id_ttd)
    {
        $f = ttd::find($id_ttd);
        if ($f) {
            $this->id_ttd = $f->id_ttd;
            $this->nama = $f->nama;
            $this->jabatan = $f->jabatan;
        }
    }
    public function render()
    {
        return view('livewire.admin.ttd.edit');
    }
}
