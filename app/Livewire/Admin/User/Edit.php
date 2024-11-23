<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Edit extends Component
{
    public $id;
    public $name;
    public $email;
    public $nim;
    public $confirmPassword;
    public $role = '';


    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->id . 'id',
            'nim' => 'nullable|string|unique:users,nim_nidn,' . $this->id . 'id',
            'confirmPassword' => 'nullable|min:8',
            'role' => 'required|in:admin,dosen,mahasiswa,staff',
        ];
    }

    public function message()
    {
        return [
            'name.required' => 'Nama tidak boleh kosong',
            'name.string' => 'Nama harus berupa huruf',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'nim.unique' => 'NIM / NIDN sudah terdaftar',
            'confirmPassword.required' => 'Password tidak boleh kosong',
            'confirmPassword.min' => 'Password minimal 8 karakter',
            'role.required' => 'Role tidak boleh kosong',
            'role.in' => 'Role tidak valid',
        ];
    }

    public function clear($id)
    {
        $this->dispatch('refreshComponent');
        $user = User::find($id);
        if ($user) {
            $this->id = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->nim = $user->nim_nidn;
            $this->role = $user->role;
        }
    }

    public function mount($id)
    {
        $user = User::find($this->id);
        if ($user) {
            $this->id = $user->id;
            $this->name = $user->name;
            $this->email = $user->email;
            $this->nim = $user->nim;
            $this->nim = $user->nim_nidn;
            $this->role = $user->role;
        }
        return $user;
    }


    public function update()
    {
        $validatedData = $this->validate();

        $user = User::find($this->id);
        if ($user) {
            // Update user data with validated data
            $user->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'nim_nidn' => $validatedData['nim'],
                'password' => Hash::make($validatedData['confirmPassword']),
                'role' => $validatedData['role'],
            ]);
            $this->mount($this->id);
            $this->dispatch('UserUpdated');
        }
    }

    public function render()
    {
        return view('livewire.admin.user.edit');
    }
}
