<?php

namespace App\Livewire\Admin\User;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Edit extends Component
{
    use WithPagination;
    public $id;
    public $name;
    public $email;
    public $password;
    public $role = '';


    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $this->id . 'id',
            'password' => 'nullable|min:8',
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
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 8 karakter',
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
                'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $user->password,
                'role' => $validatedData['role'],
            ]);

            // Reset form and dispatch event
            // $this->reset();
            $this->mount($this->id);
            $this->dispatch('UserUpdated');
        }
    }

    public function render()
    {
        return view('livewire.admin.user.edit');
    }
}
