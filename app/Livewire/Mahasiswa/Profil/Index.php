<?php

namespace App\Livewire\Mahasiswa\Profil;

use Livewire\Component;
use Auth;
use Hash;
use App\Models\Mahasiswa;
use App\Models\Prodi;

class Index extends Component
{
    public $currentPassword = '';
    public $newPassword = '';
    public $confirmPassword = '';

    public function resetpw()
    {
        $user = Auth::user();

        // Check if the current password input matches the hashed password in the database
        if (Hash::check($this->currentPassword, $user->password)) {
            // Check if the new password matches the confirmation password
            if ($this->newPassword === $this->confirmPassword) {
                // Update the user's password with the hashed new password
                if ($this->newPassword === $this->currentPassword) {
                    $this->dispatch('warning', ['message' => 'Password Baru Tidak Boleh Sama Dengan Password Lama']);
                } else {
                    $user->update([
                        'password' => Hash::make($this->newPassword),
                    ]);

                    $this->dispatch('updated', ['message' => 'Password Berhasil di Update']);
                }
            } else {
                $this->dispatch('warning', ['message' => 'Password Baru Tidak Sama']);

            }
        } else {
            $this->dispatch('warning', ['message' => 'Password Lama Tidak Sesuai']);
        }
        $this->reset('currentPassword', 'newPassword', 'confirmPassword');
        // dd($this->currentPassword, $this->newPassword, $this->confirmPassword);
    }

    public function render()
    {
        $mahasiswa = Mahasiswa::where('NIM', Auth()->user()->nim_nidn)->first();

        // dd($mahasiswa->nama);
        return view('livewire.mahasiswa.profil.index',[
            'mahasiswa' => $mahasiswa
        ]);
    }
}
