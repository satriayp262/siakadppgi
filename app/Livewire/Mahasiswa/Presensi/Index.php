<?php

namespace App\Livewire\Mahasiswa\Presensi;

use Livewire\Component;
use App\Models\Token;
use App\Models\Presensi;
use App\Models\Mahasiswa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $nama;
    public $nim;
    public $token;

    public function mount()
    {
        // Ambil user yang login
        $mahasiswa = Mahasiswa::where('NIM', Auth::user()->nim_nidn)->first();
        if ($mahasiswa) {
            $this->nama = $mahasiswa->nama;
            $this->nim = $mahasiswa->NIM;
        } else {
            session()->flash('error', 'Data mahasiswa tidak ditemukan.');
            // Redirect atau tindakan lain jika perlu
        }
    }

    public function submit()
    {
        // $this->validate();

        // Cari token berdasarkan input
        $tokenData = Token::where('token', $this->token)->first();

        // Jika token tidak ditemukan, return atau beri pesan error
        if (!$tokenData) {
            $this->dispatch('warning', ['message' => 'Token tidak ditemukan']);
            $this->reset();
            return;
        }

        // Cek apakah mahasiswa sudah pernah presensi dengan token yang sama
        $existingPresensi = Presensi::where('nim', $this->nim)
            ->where('token', $tokenData->token)
            ->exists();

        if ($existingPresensi) {
            session()->flash('error', 'Anda sudah melakukan presensi dengan token ini.');
            $this->reset();
            return;
        }

        // Simpan data presensi
        Presensi::create([
            'nama' => $this->nama,
            'nim' => $this->nim,
            'token' => $tokenData->token,
            'waktu_submit' => Carbon::now(),
        ]);

        $this->reset();
        $this->dispatch('updated', ['message' => 'Presensi Berhasil di Submit']);
    }


    public function render()
    {
        return view('livewire.mahasiswa.presensi.index');
    }
}
