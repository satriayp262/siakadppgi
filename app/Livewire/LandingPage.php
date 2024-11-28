<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pengumuman;  // Import Model Pengumuman


class LandingPage extends Component
{

    public function render()
    {
        $pengumuman = Pengumuman::all(); // Mengambil data dari model Pengumuman
        return view('livewire.landing-page', [
            'pengumuman' => $pengumuman
        ])->layout('components.layouts.guest');
    }
}
