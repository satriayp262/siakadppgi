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
        $user = Auth::user();
        $mahasiswa = Mahasiswa::where('id_user', $user->id)->first();
        $this->nim = $mahasiswa->NIM ?? null;
        $this->nama = $mahasiswa->nama;
        if ($mahasiswa) {
            $this->nama = $mahasiswa->nama;
            $this->nim = $mahasiswa->NIM;
        } else {
            session()->flash('error', 'Data mahasiswa tidak ditemukan.');
            // Redirect atau tindakan lain jika perlu
        }
    }


    protected $rules = [
        'token' => 'required|string|exists:tokens,token',
    ];

    public function submit()
    {
        $this->validate();

        // Cari token berdasarkan input
        $tokenData = Token::where('token', $this->token)->first();

        // Simpan data presensi
        Presensi::create([
            'nama' => $this->nama,
            'nim' => $this->nim,
            'token_id' => $tokenData->id,
            'waktu_submit' => Carbon::now(),
        ]);

        session()->flash('message', 'Presensi berhasil disubmit!');
        $this->reset(['token']);
    }

    public function render()
    {
        return view('livewire.mahasiswa.presensi.index');
    }
}
