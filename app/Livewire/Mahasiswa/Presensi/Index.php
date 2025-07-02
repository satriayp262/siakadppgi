<?php

namespace App\Livewire\Mahasiswa\Presensi;

use Livewire\Component;
use App\Models\Token;
use App\Models\Presensi;
use App\Models\Mahasiswa;
use App\Models\Krs;
use App\Models\Jadwal;
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

        // Validasi KRS: Pastikan mahasiswa mengambil kelas dan matkul yang sesuai
        $mahasiswa = Mahasiswa::where('NIM', $this->nim)->first();
        $krsValid = Krs::where('id_mahasiswa', $mahasiswa->id_mahasiswa ?? null)
            ->where('id_kelas', $tokenData->id_kelas)
            ->where('id_mata_kuliah', $tokenData->id_mata_kuliah)
            ->exists();

        if (!$krsValid) {
            $this->dispatch('error', ['message' => 'Anda tidak terdaftar di mata kuliah dan kelas ini.']);
            return;
        }

        // Validasi Jadwal: Presensi hanya saat jadwal berlangsung
        $jadwal = \App\Models\Jadwal::where('id_kelas', $tokenData->id_kelas)
            ->where('id_mata_kuliah', $tokenData->id_mata_kuliah)
            ->whereDate('tanggal', Carbon::now()->toDateString())
            ->first();

        if (!$jadwal) {
            $this->dispatch('error', ['message' => 'Jadwal kuliah tidak ditemukan untuk hari ini.']);
            return;
        }

        $now = Carbon::now();
        $jamMulai = Carbon::parse($jadwal->tanggal . ' ' . $jadwal->jam_mulai);
        $jamSelesai = Carbon::parse($jadwal->tanggal . ' ' . $jadwal->jam_selesai);

        if (!$now->between($jamMulai, $jamSelesai)) {
            $this->dispatch('error', ['message' => 'Presensi hanya bisa dilakukan saat sesi berlangsung.']);
            return;
        }

        // Validasi presensi ganda
        $alreadyPresensi = Presensi::where('nim', $this->nim)
            ->where('token', $tokenData->token)
            ->exists();

        if ($alreadyPresensi) {
            $this->dispatch('error', ['message' => 'Anda sudah melakukan presensi untuk token ini.']);
            $this->reset(['token', 'keterangan', 'alasan']);
            return;
        }

        Presensi::create([
            'nama' => $this->nama,
            'nim' => $this->nim,
            'token' => $tokenData->token,
            'waktu_submit' => $now,
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
