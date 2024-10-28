<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Matakuliah;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;

class CreateToken extends Component
{
    public $id_mata_kuliah, $matkul;
    public $valid_until;

    protected $rules = [
        'id_mata_kuliah' => 'required|exists:matkul,id_mata_kuliah',
        'valid_until' => 'required|date|after:now',
    ];

    public function mount()
    {
        $this->matkul = Matakuliah::all(); // Mengambil semua mata kuliah
    }

    public function save()
    {
        $this->validate();

        $token = Str::random(6); // Generate random token

        Token::create([
            'token' => $token,
            'id_mata_kuliah' => $this->id_mata_kuliah,
            'valid_until' => $this->valid_until,
            'id' => Auth::user()->id,
        ]);

        $this->resetExcept('matkul');
        $this->dispatch('tokenCreated', $token);
    }

    public function render()
    {
        return view('livewire.dosen.presensi.create-token');
    }
}
