<?php

namespace App\Livewire\Mahasiswa\Keuangan;

use App\Models\Mahasiswa;
use Livewire\Component;
use App\Models\Semester;
use App\Models\Tagihan;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;


class Create extends Component
{

    use WithFileUploads;

    public $NIM;
    public $total_tagihan;
    public $id_semester;
    public $bukti_bayar_tagihan;
    public $tagihan;
    public $id_tagihan;
    public $status_tagihan;



    public function render()
    {
        $user = auth()->user(); // Get the currently logged-in user

        $tagihans = Tagihan::whereHas('mahasiswa', function ($query) use ($user) {
            $query->where('NIM', $user->nim_nidn); // Match the user with mahasiswa
        })->where('status_tagihan', 'Belum Lunas')->get();
        return view(
            'livewire.mahasiswa.keuangan.create',
            [
                'tagihans' => $tagihans,
                'semesters' => Semester::all(),
            ]
        );
    }
}
