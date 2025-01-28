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

    public function submit()
    {
        // Validasi input
        $this->validate([
            'token' => 'required|string',
            'keterangan' => 'required|in:Hadir,Ijin,Sakit',
            'alasan' => 'required_if:keterangan,Ijin',
        ]);

        // Cari token berdasarkan input
        $tokenData = Token::where('token', $this->token)->first();

        // Jika token tidak ditemukan, beri pesan error
        if (!$tokenData) {
            $this->dispatch('error', ['message' => 'Token tidak ditemukan.']);
            $this->reset(['token', 'keterangan', 'alasan']);
            return;
        }

        // Pastikan data `id_mata_kuliah` ada
        if (!$tokenData->id_mata_kuliah || !$tokenData->id_kelas) {
            $this->dispatch('error', ['message' => 'Data mata kuliah atau kelas tidak ditemukan untuk token ini.']);
            $this->reset(['token', 'keterangan', 'alasan']);
            return;
        }

        // // Cek apakah mahasiswa terdaftar dalam kelas yang sama dengan token
        // $isRegisteredInClass = Krs::where('nim', $this->nim)
        //     ->where('id_kelas', $tokenData->id_kelas)
        //     ->exists();

        // if (!$isRegisteredInClass) {
        //     $this->dispatch('error', ['message' => 'Anda tidak terdaftar dalam kelas ini.']);
        //     $this->reset(['token', 'keterangan', 'alasan']);
        //     return;
        // }

        // Cek apakah mahasiswa sudah melakukan presensi dengan token yang sama
        $existingPresensi = Presensi::where('nim', $this->nim)
            ->where('token', $tokenData->token)
            ->exists();

        if ($existingPresensi) {
            $this->dispatch('error', ['message' => 'Anda sudah melakukan presensi dengan token ini.']);
            $this->reset(['token', 'keterangan', 'alasan']);
            return;
        }

        // Simpan data presensi
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

        // Kirim pesan sukses
        $this->dispatch('presensiCreated', ['message' => 'Presensi berhasil disubmit.']);
        $this->reset(['token', 'keterangan', 'alasan']);
    }

    public function render()
    {
        return view('livewire.mahasiswa.presensi.index');
    }
}
