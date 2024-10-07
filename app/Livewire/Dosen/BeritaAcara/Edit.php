<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\Dosen;
use App\Models\BeritaAcara;
use App\Models\Matakuliah;
use Livewire\Component;

class Edit extends Component
{
    public $beritaAcaraId, $tanggal, $nidn = '', $materi, $kode_mata_kuliah = '', $jumlah_mahasiswa, $matkul, $dosen;

    public function rules()
    {
        return [
            'id_berita_acara' => 'required',
            'tanggal' => 'required',
            'nidn' => 'required|string|min:10|max:10',
            'materi' => 'required|string',
            'kode_mata_kuliah' => 'required|string|max:255',
            'jumlah_mahasiswa' => 'required|string|max:255',
        ];
    }

    public function clear($id_berita_acara)
    {
        $this->reset();
        $this->dispatch('refreshComponent');
        $acara = BeritaAcara::find($id_berita_acara);
        if ($id_berita_acara) {
            $this->beritaAcaraId = $id_berita_acara->id_berita_acara;
            $this->nidn = $id_berita_acara->nidn;
            $this->kode_mata_kuliah = $id_berita_acara->kode_mata_kuliah;
            $this->materi = $id_berita_acara->materi;
            $this->jumlah_mahasiswa = $id_berita_acara->jumlah_mahasiswa;
        }
    }

    protected $listeners = ['refreshComponent' => '$refresh'];
    public function placeholder()
    {
        return <<<'BLADE'
        <div>
            <h5 class="card-title placeholder-glow">
                <span class="placeholder col-4"></span>
            </h5>
            <p class="card-text placeholder-glow">
                <span class="placeholder col-7"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-4"></span>
                <span class="placeholder col-6"></span>
                <span class="placeholder col-8"></span>
            </p>
        </div>
        BLADE;
    }

    public function mount($id_berita_acara)
    {
        $acara = BeritaAcara::find($id_berita_acara);
        $this->dosen = Dosen::all();  // Ambil semua dosen

        // Jika $acara ditemukan, set nilai properti dari data acara
        if ($acara) {
            $this->beritaAcaraId = $acara->id_berita_acara;
            $this->tanggal = $acara->tanggal;
            $this->nidn = $acara->nidn;
            $this->materi = $acara->materi;
            $this->kode_mata_kuliah = $acara->kode_mata_kuliah;
            $this->jumlah_mahasiswa = $acara->jumlah_mahasiswa;

            // Ambil mata kuliah yang terkait dengan dosen berdasarkan NIDN
            $this->matkul = Matakuliah::where('nidn', $this->nidn)->get();
        } else {
            $this->matkul = collect();  // Jika tidak ada acara, set mata kuliah sebagai koleksi kosong
        }
    }

    public function updatedNidn($value)
    {
        // Ketika nidn berubah, ambil matkul yang terkait dengan nidn yang dipilih
        $this->matkul = Matakuliah::where('nidn', $value)->get();
    }

    public function update()
    {

        $validatedData = $this->validate([
            'tanggal' => 'required',
            'nidn' => 'required|string|min:10|max:10',
            'materi' => 'required|string',
            'kode_mata_kuliah' => 'required|string|max:255',
            'jumlah_mahasiswa' => 'required|string|max:255',
        ]);

        $acara = BeritaAcara::find($this->id_berita_acara);
        $acara->update([
            'nama_dosen' => $validatedData['nama_dosen'],
            'nidn' => $validatedData['nidn'],
            'kode_mata_kuliah' => $validatedData['kode_mata_kuliah'],
            'materi' => $validatedData['materi'],
            'jumlah_mahasiswa' => $validatedData['jumlah_mahasiswa'],
        ]);

        // Reset form dan dispatch event
        $this->resetExcept('nidn,kode_mata_kuliah');
        $this->dispatch('acaraUpdated');
        return $acara;
    }

    public function render()
    {
        return view('livewire.dosen.berita_acara.edit');
    }
}
