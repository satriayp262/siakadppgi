<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Dosen;
use App\Models\BeritaAcara;
use App\Models\Matakuliah;
use Livewire\Component;

class Edit extends Component
{
    public $id_berita_acara, $tanggal, $nidn, $nama_dosen, $materi, $id_mata_kuliah, $jumlah_mahasiswa, $matkul, $dosen;

    public function rules()
    {
        return [
            'tanggal' => 'required|date',
            'nidn' => 'required|string|min:10|max:10',
            'materi' => 'required|string',
            'id_mata_kuliah' => 'required|integer|max:255',
            'jumlah_mahasiswa' => 'required|integer|min:1',
        ];
    }

    public function clear($id_berita_acara)
    {
        $this->reset();

        $acara = BeritaAcara::find($id_berita_acara);
        if ($acara) {
            $this->id_berita_acara = $acara->id_berita_acara;
            $this->tanggal = $acara->tanggal;
            $this->nidn = $acara->nidn;
            $this->id_mata_kuliah = $acara->id_mata_kuliah;
            $this->materi = $acara->materi;
            $this->jumlah_mahasiswa = $acara->jumlah_mahasiswa;
            $this->loadDosenName($acara->nidn);
        }
    }

    public function mount($id_berita_acara)
    {
        $acara = BeritaAcara::find($id_berita_acara);
        $this->dosen = Dosen::all();
        $this->matkul = Matakuliah::all();

        if ($acara) {
            $this->id_berita_acara = $acara->id_berita_acara;
            $this->tanggal = $acara->tanggal;
            $this->nidn = $acara->nidn;
            $this->id_mata_kuliah = $acara->id_mata_kuliah;
            $this->materi = $acara->materi;
            $this->jumlah_mahasiswa = $acara->jumlah_mahasiswa;
            $this->loadDosenName($acara->nidn);
        }
    }

    protected function loadDosenName($nidn)
    {
        $dosen = Dosen::where('nidn', $nidn)->first();
        $this->nama_dosen = $dosen ? $dosen->nama_dosen : '';
    }

    public function update()
    {
        $validatedData = $this->validate();

        $acara = BeritaAcara::find($this->id_berita_acara);
        if ($acara) {
            $acara->update($validatedData);

            $this->reset();
            $this->dispatch('acaraUpdated');
        }
    }

    public function render()
    {
        $matkuls = Matakuliah::all();
        return view('livewire.dosen.berita_acara.edit', [
            'matkuls' => $matkuls
        ]);
    }
}
