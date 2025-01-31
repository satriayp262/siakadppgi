<?php

namespace App\Livewire\Mahasiswa\Presensi;

use Livewire\Component;
use App\Models\Token;
use App\Models\Presensi;
use App\Models\Mahasiswa;
use App\Models\Krs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Index extends Component
{
    public $nama;
    public $nim;
    public $token;
    public $keterangan;
    public $alasan;

    public function mount()
    {
        $mahasiswa = Mahasiswa::where('NIM', Auth::user()->nim_nidn)->first();
        if ($mahasiswa) {
            $this->nama = $mahasiswa->nama;
            $this->nim = $mahasiswa->NIM;
        } else {
            session()->flash('error', 'Data mahasiswa tidak ditemukan.');
        }
    }

    #[On('presensiCreated')]
    public function handletokenCreated()
    {
        $this->dispatch('created',  ['message' => 'Presensi berhasil dibuat']);
        $this->reset(['token', 'keterangan', 'alasan']);
    }

    private function tandaiAlfa($tokenData)
    {
        // Ambil semua mahasiswa di kelas ini dari tabel KRS
        $mahasiswaTerdaftar = Krs::where('id_mata_kuliah', $tokenData->id_mata_kuliah)
            ->where('id_kelas', $tokenData->id_kelas)
            ->pluck('nim');

        // Cek siapa yang sudah presensi
        $sudahPresensi = Presensi::whereIn('nim', $mahasiswaTerdaftar)
            ->where('token', $tokenData->token)
            ->pluck('nim');

        // Ambil mahasiswa yang belum presensi
        $belumPresensi = $mahasiswaTerdaftar->diff($sudahPresensi);

        foreach ($belumPresensi as $nim) {
            Presensi::create([
                'nama' => 'Mahasiswa', // Atau bisa ambil dari tabel Mahasiswa
                'nim' => $nim,
                'token' => $tokenData->token,
                'waktu_submit' => Carbon::now(),
                'keterangan' => 'Alpha',
                'id_kelas' => $tokenData->id_kelas,
                'id_mata_kuliah' => $tokenData->id_mata_kuliah,
                'alasan' => null,
            ]);
        }
    }

    public function submit()
    {
        $this->validate([
            'token' => 'required|string',
            'keterangan' => 'required|in:Hadir,Ijin,Sakit',
            'alasan' => 'required_if:keterangan,Ijin',
        ]);

        $tokenData = Token::where('token', $this->token)->first();

        if (!$tokenData) {
            $this->dispatch('error', ['message' => 'Token tidak ditemukan.']);
            $this->reset(['token', 'keterangan', 'alasan']);
            return;
        }

        // Cek apakah token sudah expired
        if (Carbon::now()->greaterThan($tokenData->valid_until)) {
            $this->tandaiAlfa($tokenData);
            $this->dispatch('error', ['message' => 'Token sudah tidak berlaku. Mahasiswa yang belum presensi ditandai sebagai Alfa.']);
            return;
        }

        $existingPresensi = Presensi::where('nim', $this->nim)
            ->where('token', $tokenData->token)
            ->exists();

        if ($existingPresensi) {
            $this->dispatch('error', ['message' => 'Anda sudah melakukan presensi dengan token ini.']);
            $this->reset(['token', 'keterangan', 'alasan']);
            return;
        }

        Presensi::create([
            'nama' => $this->nama,
            'nim' => $this->nim,
            'token' => $tokenData->token,
            'waktu_submit' => Carbon::now(),
            'keterangan' => $this->keterangan,
            'id_kelas' => $tokenData->id_kelas,
            'id_mata_kuliah' => $tokenData->id_mata_kuliah,
            'alasan' => $this->alasan ?? null,
        ]);

        $this->dispatch('presensiCreated', ['message' => 'Presensi berhasil disubmit.']);
        $this->reset(['token', 'keterangan', 'alasan']);
    }

    public function render()
    {
        return view('livewire.mahasiswa.presensi.index');
    }
}
