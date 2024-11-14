<?php

namespace App\Livewire\Admin\Dosen;
use App\Models\User;
use App\Models\Dosen;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateUserDosen extends Component
{
    public $id_dosen, $nama_dosen, $nidn, $email, $password;

    public function mount()
    {
        if ($this->id_dosen) {
            $dosen = Dosen::find($this->id_dosen);

            if ($dosen) {
                $this->nama_dosen = $dosen->nama_dosen;
                $this->nidn = $dosen->nidn;
                $this->password = $dosen->nidn;
            }
        }
    }

    public function createUser()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        User::create([
            'name' => $this->nama_dosen,
            'email' => $this->email,
            'nim_nidn' => $this->nidn,
            'password' => Hash::make($this->password), // Enkripsi password NIDN
            'role' => 'dosen',
        ]);

        $this->reset(['email', 'password']);

        $this->dispatch('userCreated');
    }
    public function render()
    {
        return view('livewire.admin.dosen.create-user-dosen');
    }
}
