<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Dosen;
use App\Models\BeritaAcara;
use App\Models\Matakuliah;
use Livewire\Component;

class Create extends Component
{
    public $id_berita_acara, $tanggal, $nidn = '', $materi, $kode_mata_kuliah = '', $jumlah_mahasiswa, $matkul, $dosen;

    public function rules()
    {
        return [
            'tanggal' => 'required|date',
            'nidn' => 'required|string|min:10|max:10',
            'materi' => 'required|string',
            'kode_mata_kuliah' => 'required|string|max:255',
            'jumlah_mahasiswa' => 'required|integer',
        ];
    }

    public function mount()
    {
        $this->matkul = Matakuliah::all() ?? collect([]);
        $this->dosen = Dosen::all() ?? collect([]);
    }

    public function save()
    {
        // Validasi data
        $validatedData = $this->validate();

        //dd($validatedData);
        // Simpan data ke database
        $acara = BeritaAcara::create([
            'tanggal' => $validatedData['tanggal'],
            'nidn' => $validatedData['nidn'],
            'materi' => $validatedData['materi'],
            'kode_mata_kuliah' => $validatedData['kode_mata_kuliah'],
            'jumlah_mahasiswa' => $validatedData['jumlah_mahasiswa'],
        ]);

        $this->resetExcept(['dosen', 'matkul']);
        $this->dispatch('acaraCreated');

        return $acara;
    }

    public function messages()
    {
        return [
            'nidn.required' => 'NIDN tidak boleh kosong',
            'tanggal.required' => 'Tanggal tidak boleh kosong',
            'materi.required' => 'Materi tidak boleh kosong',
            'kode_mata_kuliah.required' => 'Mata kuliah tidak boleh kosong',
            'jumlah_mahasiswa.required' => 'Jumlah mahasiswa tidak boleh kosong',
        ];
    }

    public function render()
    {
        return view('livewire.dosen.berita_acara.create');
    }
}
