<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Password;

class ForgotPassword extends Component
{
    public $email;

    protected $rules = [
        'email' => ['required', 'regex:/^[\w\.-]+@gmail\.com$/'],
    ];

    protected $messages = [
        'email.required' => 'Email wajib diisi',
        'email.regex' => 'Email harus berupa @gmail.com',
    ];

    public function sendResetLink()
    {
        $this->validate();

        $status = Password::sendResetLink(['email' => $this->email]);

        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('message', 'Tautan reset password telah dikirim ke email Anda.');
        } elseif ($status === Password::RESET_THROTTLED) {
            session()->flash('error', 'Tunggu beberapa saat untuk mencoba lagi');
        } else {
            session()->flash('error', 'Email tidak ditemukan dalam sistem.');
        }
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('components.layouts.guest');
    }
}
