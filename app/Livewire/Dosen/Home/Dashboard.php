<?php

namespace App\Livewire\Dosen\Home;

use Livewire\Component;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $dosen, $user;

    public function mount()
    {
        // Ambil data dosen berdasarkan NIDN yang dimiliki oleh user yang sedang login
        $this->dosen = Dosen::where('nidn', Auth::user()->nim_nidn)->first();

        // Pastikan dosen ditemukan
        if ($this->dosen) {
            // Ambil data user berdasarkan nim_nidn yang sama dengan dosen
            $this->user = User::where('nim_nidn', $this->dosen->nidn)->first();
        }

        // Jika data dosen tidak ditemukan, beri pesan atau tangani sesuai kebutuhan
        if (!$this->dosen) {
            session()->flash('error', 'Data Dosen tidak ditemukan!');
        }
    }

    public function render()
    {
        return view('livewire.dosen.home.dashboard');
    }
}
