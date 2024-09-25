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
        // Validate the email before sending the reset link
        $this->validate();

        // Attempt to send the reset password link
        $status = Password::sendResetLink(['email' => $this->email]);

        // Check the status and provide feedback
        if ($status === Password::RESET_LINK_SENT) {
            session()->flash('message', 'Tautan reset password telah dikirim ke email Anda.');
        } elseif ($status === Password::RESET_THROTTLED) {
            // Calculate the wait time until the user can attempt again
            session()->flash('message', 'Too many attempts. Please wait before trying again.');
        } else {
            session()->flash('message', 'Email tidak ditemukan dalam sistem.');
        }
        // dd($status);
    }

    public function render()
    {
        return view('livewire.auth.forgot-password')->layout('components.layouts.guest');
    }
}
