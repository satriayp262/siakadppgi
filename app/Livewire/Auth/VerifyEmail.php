<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Auth;

class VerifyEmail extends Component
{
    public $resent = false;

    public function resendVerificationLink()
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->resent = false;
            session()->flash('message', 'Email Anda sudah terverifikasi.');
            return;
        }

        Auth::user()->sendEmailVerificationNotification();
        $this->resent = true;

        session()->flash('message', 'Tautan verifikasi telah dikirim ke email Anda.');
    }

    public function render()
    {
        return view('livewire.auth.verify-email')->layout('components.layouts.guest');
    }
}
