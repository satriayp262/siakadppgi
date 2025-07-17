<?php

namespace App\Livewire\Dosen\BeritaAcara;

use App\Models\BeritaAcara;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Matakuliah;
use App\Models\Presensi;
use App\Models\Semester;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Create extends Component
{
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

    public function mount($token)
    {
        $this->token = $token;

        // Ambil data token dan relasinya termasuk jadwal
        $tokenData = Token::with(['matkul', 'kelas', 'jadwal'])->where('token', $token)->firstOrFail();

        $this->tanggal = $tokenData->created_at->format('d-m-Y');
        $this->pertemuan = $tokenData->pertemuan;
        $this->id_mata_kuliah = $tokenData->id_mata_kuliah;
        $this->id_kelas = $tokenData->id_kelas;
        $this->nama_mata_kuliah = $tokenData->matkul->nama_mata_kuliah ?? '-';
        $this->nama_kelas = $tokenData->kelas->nama_kelas ?? '-';

        // Ambil sesi dari relasi jadwal
        $this->sesi = $tokenData->jadwal->sesi ?? '-';

        // Hitung jumlah mahasiswa dari presensi
        $this->jumlah_mahasiswa = Presensi::where('token', $token)
            ->where('keterangan', 'Hadir')
            ->count();

        // Ambil dosen berdasarkan user login
        $user = Auth::user();
        $dosen = Dosen::where('nidn', $user->nim_nidn)->first();

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

    public function save()
    {
        $this->validate();

        BeritaAcara::create([
            'tanggal' => \Carbon\Carbon::createFromFormat('d-m-Y', $this->tanggal)->format('Y-m-d'),
            'nidn' => $this->nidn,
            'materi' => $this->materi,
            'jumlah_mahasiswa' => $this->jumlah_mahasiswa,
            'token' => $this->token,
            'keterangan' => $this->keterangan,
        ]);

        $this->reset(['materi', 'keterangan']);
        $this->dispatch('acaraCreated');
    }

    public function render()
    {
        return view('livewire.dosen.berita_acara.create');
    }
}
