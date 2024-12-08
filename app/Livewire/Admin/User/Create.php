<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Create extends Component
{
    public $name;
    public $email;
    public $nim;
    public $confirmPassword;
    public $role = ' ';


    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'nim' => 'nullable|string|unique:users,nim_nidn',
            'confirmPassword' => 'required|min:8',
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

    public function save()
    {
        $validatedData = $this->validate();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'nim_nidn' => $validatedData['nim'],
            'password' => Hash::make($validatedData['confirmPassword']),
            'role' => $validatedData['role'],
        ]);

        $this->reset();
        $this->dispatch('UserCreated');
        return $user;
    }

    public function clear()
    {
        $this->name = '';
        $this->email = '';
        $this->nim = '';
        $this->confirmPassword = '';
        $this->role = ' ';
        $this->ttd = '';
    }

    public function render()
    {
        return view('livewire.admin.user.create');
    }
}
