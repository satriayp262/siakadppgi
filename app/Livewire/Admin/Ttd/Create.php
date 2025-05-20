<?php

namespace App\Livewire\Admin\Ttd;

use App\Models\ttd;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
class Create extends Component
{
    use WithFileUploads;
    public $nama;
    public $jabatan;
    public $ttd;

    public function save()
    {
        $this->validate([
            'nama' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'ttd' => 'nullable|image|max:1024' // 1MB max
        ]);

        $komponen = new ttd;

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
        $komponen->create($data);

        // Kirimkan event ke Livewire atau browser
        $this->dispatch('ttdCreated');
    }

    public function render()
    {
        return view('livewire.admin.ttd.create');
    }
}
