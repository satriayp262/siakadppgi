<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Dosen;
use App\Models\BeritaAcara;
use App\Models\Matakuliah;
use Livewire\Component;

class Edit extends Component
{
    public $id_berita_acara, $tanggal, $nidn = '', $nama_dosen = '', $materi, $id_mata_kuliah = '', $jumlah_mahasiswa, $matkul, $dosen;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function rules()
    {
        return [
            'id_berita_acara' => 'required',
            'tanggal' => 'required|date',
            'nidn' => 'required|string|min:10|max:10',
            'materi' => 'required|string',
            'id_mata_kuliah' => 'required|string|max:255',
            'jumlah_mahasiswa' => 'required|integer|min:1',
        ];
    }

    public function clear($id_berita_acara)
    {
        $this->resetExcept(['dosen', 'matkul']);
        $this->dispatch('refreshComponent');

        $acara = BeritaAcara::find($id_berita_acara);
        if ($acara) {
            $this->id_berita_acara = $acara->id_berita_acara;
            $this->tanggal = $acara->tanggal;
            $this->nidn = $acara->nidn;
            $this->id_mata_kuliah = (string) $acara->id_mata_kuliah; // Pastikan ini adalah string
            $this->materi = $acara->materi;
            $this->jumlah_mahasiswa = $acara->jumlah_mahasiswa;
            $this->loadDosenName($this->nidn); // Load nama dosen berdasarkan NIDN
        }
    }

    public function mount($id_berita_acara)
    {
        $this->dosen = Dosen::all();
        $this->matkul = Matakuliah::all();
        $this->clear($id_berita_acara); // Panggil clear untuk mengisi data saat mount
    }

    protected function loadDosenName($nidn)
    {
        $dosen = Dosen::where('nidn', $nidn)->first();
        $this->nama_dosen = $dosen ? $dosen->nama_dosen : '';
    }

    public function update()
    {
        $validatedData = $this->validate();

        // Pastikan id_mata_kuliah adalah string
        $validatedData['id_mata_kuliah'] = (string) $validatedData['id_mata_kuliah'];

        $acara = BeritaAcara::find($this->id_berita_acara);
        if ($acara) {
            try {
                $acara->update($validatedData);

                // Reset form except 'dosen' and 'matkul'
                $this->resetExcept(['dosen', 'matkul']);
                $this->dispatch('acaraUpdated');
            } catch (\Exception $e) {
                session()->flash('error', 'Gagal memperbarui data: ' . $e->getMessage());
            }
        }
    }

    public function render()
    {
        return view('livewire.dosen.berita_acara.edit');
    }
}
