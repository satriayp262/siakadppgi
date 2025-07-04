<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Auth;
use App\Models\User;

class Login extends Component
{
    public $email;
    public $password;

    protected $rules = [
        'email' => 'required',
        'password' => 'required',
    ];

    protected $messages = [
        'email.required' => 'Email wajib diisi',
        'password.required' => 'Password wajib diisi',
    ];


    public function login()
    {
        $this->validate();

        if (Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $user = Auth::user();
            // dd($user);
            if ($user->role === 'mahasiswa') {
                return redirect()->intended('/mahasiswa/keuangan');
            } elseif ($user->role === 'dosen') {
                return redirect()->intended('/dosen/Dashboard');
            } elseif ($user->role === 'staff') {
                return redirect()->intended('/staff/dashboard');
            } elseif ($user->role === 'admin') {
                //route
            }
            return redirect()->intended('/admin/dashboard');
        }

        if (!User::where('email', $this->email)->exists()) {
            session()->flash('message', 'Email tidak ditemukan.');
        } else if (User::where('email', $this->email)->exists()) {
            session()->flash('message', 'Password salah.');
        }

        $this->password = '';
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('components.layouts.guest');
    }
}
