<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\BeritaAcara;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Matakuliah;
use App\Models\Presensi;
use App\Models\Token;
use Livewire\Component;
use Carbon\Carbon;

class Edit extends Component
{
    public $id_berita_acara;
    public $token;
    public $tanggal;
    public $pertemuan;
    public $sesi;
    public $nidn = '';
    public $nama_dosen = '';
    public $materi;
    public $keterangan;
    public $id_kelas;
    public $id_mata_kuliah;
    public $jumlah_mahasiswa;
    public $nama_kelas;
    public $nama_mata_kuliah;

    public function mount($id_berita_acara)
    {
        $this->id_berita_acara = $id_berita_acara;

        // Load existing berita acara data
        $beritaAcara = BeritaAcara::findOrFail($id_berita_acara);

        // Load token data and relationships
        $tokenData = Token::with(['matkul', 'kelas'])
                        ->where('token', $beritaAcara->token)
                        ->firstOrFail();

        $this->token = $beritaAcara->token;

        // Fix: Ensure we're working with a Carbon instance
        $this->tanggal = Carbon::parse($beritaAcara->tanggal)->format('d-m-Y');

        $this->pertemuan = $tokenData->pertemuan;
        $this->sesi = $tokenData->sesi;
        $this->id_mata_kuliah = $tokenData->id_mata_kuliah;
        $this->id_kelas = $tokenData->id_kelas;
        $this->nama_mata_kuliah = $tokenData->matkul->nama_mata_kuliah ?? '-';
        $this->nama_kelas = $tokenData->kelas->nama_kelas ?? '-';
        $this->materi = $beritaAcara->materi;
        $this->keterangan = $beritaAcara->keterangan;

        // Count students from presensi
        $this->jumlah_mahasiswa = Presensi::where('token', $beritaAcara->token)->count();

        // Load dosen data
        $dosen = Dosen::where('nidn', $beritaAcara->nidn)->first();
        if ($dosen) {
            $this->nidn = $dosen->nidn;
            $this->nama_dosen = $dosen->nama_dosen;
        }
    }

    public function rules()
    {
        return [
            'materi' => 'required|string',
            'keterangan' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'materi.required' => 'Materi tidak boleh kosong',
        ];
    }

    public function update()
    {
        $this->validate();

        $beritaAcara = BeritaAcara::findOrFail($this->id_berita_acara);

        $beritaAcara->update([
            'materi' => $this->materi,
            'keterangan' => $this->keterangan,
            'jumlah_mahasiswa' => $this->jumlah_mahasiswa,
        ]);

        $this->dispatch('acaraUpdated');
    }

    public function render()
    {
        return view('livewire.dosen.berita_acara.edit');
    }
}
