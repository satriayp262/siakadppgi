<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Dosen;
use App\Models\BeritaAcara;
use App\Models\Matakuliah;
use Livewire\Component;

class Create extends Component
{
    public $beritaAcaraId, $tanggal, $nidn = '', $materi, $kode_mata_kuliah = '', $jumlah_mahasiswa, $matkul, $dosen;

    public function rules()
    {
        return [
            'tanggal' => 'required',
            'nidn' => 'required|string|min:10|max:10',
            'materi' => 'required|string',
            'kode_mata_kuliah' => 'required|string|max:255',
            'jumlah_mahasiswa' => 'required|string|max:255',
        ];
    }

    public function mount()
    {
        // Ambil data dosen berdasarkan $nidn yang dipilih
        $dosen = Dosen::where('nidn', $this->nidn)->first();

        // Ambil data matkul yang terkait dengan dosen yang dipilih
        if ($dosen) {
            $this->matkul = Matakuliah::where('nidn', $this->nidn)->get();
        } else {
            $this->matkul = collect(); // Jika tidak ditemukan dosen, atur $matkul sebagai koleksi kosong
        }

        // Ambil semua data dosen
        $this->dosen = Dosen::all();
    }

    public function save()
    {
        // Validasi data
        $validatedData = $this->validate();
        // Simpan data ke database
        $acara = BeritaAcara::create([
            'tanggal' => $validatedData['tanggal'],
            'nidn' => $validatedData['nidn'],
            'materi' => $validatedData['materi'],
            'kode_mata_kuliah' => $validatedData['kode_mata_kuliah'],
            'jumlah_mahasiswa' => $validatedData['jumlah_mahasiswa'],
        ]);

        $this->resetExcept('nidn,kode_mata_kuliah');

        $this->dispatch('acaraCreated');

        return $acara;
    }
    public function render()
    {
        return view('livewire.dosen.berita-acara.create');
    }
}
