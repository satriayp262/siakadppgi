<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Matakuliah;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Token;
use App\Models\Kelas;
use App\Models\Dosen;
use Illuminate\Support\Facades\Auth;

class CreateToken extends Component
{
    public $id_mata_kuliah, $matkul, $nama_mata_kuliah, $id_kelas, $nama_kelas;
    public $valid_until;

    protected $rules = [
        'id_mata_kuliah' => 'required|exists:matkul,id_mata_kuliah',
        'id_kelas' => 'required|exists:kelas,id_kelas',
        'valid_until' => 'required|date|after:now',
    ];

    public function mount()
    {
        if ($this->id_mata_kuliah) {
            // Fetch Matakuliah
            $matkul = Matakuliah::find($this->id_mata_kuliah);
            if ($matkul) {
                $this->nama_mata_kuliah = $matkul->nama_mata_kuliah;
            }
        }

        if ($this->id_kelas) {
            // Fetch Kelas
            $kelas = Kelas::find($this->id_kelas);
            if ($kelas) {
                $this->nama_kelas = $kelas->nama_kelas;
            }
        }
    }

    public function save()
    {
        $this->validate();

        $token = Str::random(6);

        Token::create([
            'token' => $token,
            'id_mata_kuliah' => $this->id_mata_kuliah,
            'id_kelas' => $this->id_kelas,
            'valid_until' => $this->valid_until,
            'id' => Auth::user()->id,
        ]);

        $this->reset();
        $this->dispatch('tokenCreated', $token);
    }

    public function render()
    {
        // // $matkuls = Matakuliah::where('nidn', auth()->user()->nim_nidn)->get();
        // $matkuls = Matakuliah::all();
        return view('livewire.dosen.presensi.create-token');
    }
}
