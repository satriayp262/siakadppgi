<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Dosen;
use App\Models\BeritaAcara;
use App\Models\Matakuliah;
use Livewire\Component;

class Edit extends Component
{
    public $id_berita_acara, $tanggal, $nidn = '', $materi, $kode_mata_kuliah = '', $jumlah_mahasiswa, $matkul, $dosen;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function rules()
    {
        return [
            'id_berita_acara' => 'required',
            'tanggal' => 'required|date',
            'nidn' => 'required|string|min:10|max:10',
            'materi' => 'required|string',
            'kode_mata_kuliah' => 'required|string|max:255',
            'jumlah_mahasiswa' => 'required|integer|min:1',
        ];
    }

    public function clear($id_berita_acara)
    {
        $this->reset();
        $this->dispatchBrowserEvent('refreshComponent');
        $acara = BeritaAcara::find($id_berita_acara);
        if ($acara) {
            $this->id_berita_acara = $acara->id_berita_acara;
            $this->tanggal = $acara->tanggal;
            $this->nidn = $acara->nidn;
            $this->kode_mata_kuliah = $acara->kode_mata_kuliah;
            $this->materi = $acara->materi;
            $this->jumlah_mahasiswa = $acara->jumlah_mahasiswa;
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
            $this->kode_mata_kuliah = $acara->kode_mata_kuliah;
            $this->materi = $acara->materi;
            $this->jumlah_mahasiswa = $acara->jumlah_mahasiswa;
        }
    }

    public function update()
    {
        $validatedData = $this->validate();

        $acara = BeritaAcara::find($this->id_berita_acara);
        if ($acara) {
            $acara->update($validatedData);

            // Reset form except 'dosen' and 'matkul'
            $this->resetExcept(['dosen', 'matkul']);
            $this->dispatch('acaraUpdated');
        }
    }

    public function render()
    {
        return view('livewire.dosen.berita_acara.edit');
    }
}
