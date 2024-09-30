<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\User;
use Auth;

class Register extends Component
{

    public $email;
    public $name;
    public $password;
    public $password_confirmation;
    protected $rules = [
        'email' => ['required', 'regex:/^[\w\.-]+@gmail\.com$/'],
        'name' => 'required|string',
        'password' => 'required|min:8|same:password_confirmation',
        'password_confirmation' => 'required'
    ];

    protected $messages = [
        'name.required' => 'Nama wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.regex' => 'Email harus berupa @gmail.com',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password harus minimal 8 karakter',
        'password.same' => 'Password dan konfirmasi password tidak cocok',
        'password_confirmation.required' => 'Konfirmasi password wajib diisi',

    ];
    public function save()
    {
        $this->validate();
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ]);

        if ($user) {
            // $user->sendEmailVerificationNotification();

            Auth::login($user);
            // irit mailtrap
            // return redirect()->route('verification.notice');
        } else {
            session()->flash('error', 'Registrasi Gagal');
        }
    }
    public function render()
    {
        return view('livewire.auth.register')->layout('components.layouts.guest');
    }
}
