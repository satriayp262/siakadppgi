<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use Livewire\Component;
use App\Models\Tagihan;
use App\Models\Mahasiswa;
use App\Models\Semester;
use Auth;

class Index extends Component
{
    public function render()
    {
        $semesters = Semester::all(); // Get all semesters

        $user = auth()->user(); // Get the currently logged-in user

        $tagihans = Tagihan::whereHas('mahasiswa', function ($query) use ($user) {
            $query->where('id_user', $user->id); // Match the user with mahasiswa
        })->get();

        // dd($tagihans);

        return view('livewire.mahasiswa.keuangan.index', [
            'tagihans' => $tagihans,
            'semesters' => $semesters,
        ]);
    }
}
