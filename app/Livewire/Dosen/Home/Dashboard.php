<?php

namespace App\Livewire\Dosen\Home;

use Livewire\Component;
use App\Models\Dosen;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class Dashboard extends Component
{
    public $dosen, $user;
    public $currentPassword = '';
    public $newPassword = '';
    public $confirmPassword = '';


    public function mount()
    {
        // Ambil data dosen berdasarkan NIDN yang dimiliki oleh user yang sedang login
        $this->dosen = Dosen::where('nidn', Auth::user()->nim_nidn)->first();

        // Pastikan dosen ditemukan
        if ($this->dosen) {
            // Ambil data user berdasarkan nim_nidn yang sama dengan dosen
            $this->user = User::where('nim_nidn', $this->dosen->nidn)->first();
        }

        // Jika data dosen tidak ditemukan, beri pesan atau tangani sesuai kebutuhan
        if (!$this->dosen) {
            session()->flash('error', 'Data Dosen tidak ditemukan!');
        }
    }

    public function resetpw()
    {
        $user = Auth::user();

        // Check if the current password input matches the hashed password in the database
        if (Hash::check($this->currentPassword, $user->password)) {
            // Check if the new password matches the confirmation password
            if ($this->newPassword === $this->confirmPassword) {
                if ($this->newPassword === $this->currentPassword) {
                    // Emit browser event for alert
                    $this->dispatch('warning', ['message' => 'Password Baru Tidak Boleh Sama Dengan Password Lama']);
                } else {
                    // Update the user's password with the hashed new password
                    $user->update([
                        'password' => Hash::make($this->newPassword),
                    ]);

                    // Emit browser event for success message
                    $this->dispatch('updated', ['message' => 'Password Berhasil di Update']);
                }
            } else {
                // Emit browser event for mismatch new password
                $this->dispatch('warning', ['message' => 'Password Baru Tidak Sama']);
            }
        } else {
            // Emit browser event for incorrect current password
            $this->dispatch('warning', ['message' => 'Password Lama Tidak Sesuai']);
        }

        $this->reset('currentPassword', 'newPassword', 'confirmPassword');
    }

    public function render()
    {
        return view('livewire.dosen.home.dashboard');
    }
}
