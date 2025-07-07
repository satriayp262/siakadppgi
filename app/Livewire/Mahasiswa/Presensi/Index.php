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
    public $id_mahasiswa;
    public $token;
    public $keterangan;
    public $alasan;

    public function mount()
    {
        $mahasiswa = Mahasiswa::where('NIM', Auth::user()->nim_nidn)->first();

        if ($mahasiswa) {
            $this->nama = $mahasiswa->nama;
            $this->nim = $mahasiswa->NIM;
            $this->id_mahasiswa = $mahasiswa->id; // simpan id_mahasiswa
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

        if (Carbon::now()->gt($tokenData->valid_until)) {
            $this->dispatch('error', ['message' => 'Token sudah tidak berlaku.']);
            return;
        }

        $krsValid = Krs::where('NIM', $this->nim)
            ->where('id_kelas', $tokenData->id_kelas)
            ->where('id_mata_kuliah', $tokenData->id_mata_kuliah)
            ->exists();

        if (!$krsValid) {
            $this->dispatch('error', ['message' => 'Anda tidak terdaftar di mata kuliah dan kelas ini.']);
            return;
        }

        // Validasi presensi ganda berdasarkan id_mahasiswa
        $alreadyPresensi = Presensi::where('id_mahasiswa', $this->id_mahasiswa)
            ->where('token', $tokenData->token)
            ->exists();

        if ($alreadyPresensi) {
            $this->dispatch('error', ['message' => 'Anda sudah melakukan presensi untuk token ini.']);
            $this->reset(['token', 'keterangan', 'alasan']);
            return;
        }

        // Simpan presensi menggunakan id_mahasiswa
        Presensi::create([
            'id_mahasiswa' => $this->id_mahasiswa,
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
