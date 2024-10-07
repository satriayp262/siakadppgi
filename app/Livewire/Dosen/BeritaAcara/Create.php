<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Dosen;
use App\Models\BeritaAcara;
use App\Models\Matakuliah;
use Livewire\Component;

class Create extends Component
{
    public $tanggal, $nidn = '', $materi, $kode_mata_kuliah = '', $jumlah_mahasiswa, $matkul, $dosen;

    public function rules()
    {
        return [
            'tanggal' => 'required|date',
            'nidn' => 'required|string|min:10|max:10',
            'materi' => 'required|string',
            'kode_mata_kuliah' => 'required|string|max:255',
            'jumlah_mahasiswa' => 'required|integer', // Pastikan ini integer sesuai tipe data di database
        ];
    }

    public function mount()
    {
        $this->matkul = Matakuliah::all();
        $this->dosen = Dosen::all();
    }

    public function save()
    {
        // Validasi data
        $validatedData = $this->validate();
        // Simpan data ke database
        $acara = BeritaAcara::create([
            // dd($validatedData),
            'tanggal' => $validatedData['tanggal'],
            'nidn' => $validatedData['nidn'],
            'materi' => $validatedData['materi'],
            'kode_mata_kuliah' => $validatedData['kode_mata_kuliah'],
            'jumlah_mahasiswa' => $validatedData['jumlah_mahasiswa'],
        ]);

        $this->resetExcept(['nidn', 'kode_mata_kuliah']);

        $this->dispatch('acaraCreated');

        return $acara;
    }

    public function render()
    {
        return view('livewire.dosen.berita_acara.create');
    }
}
