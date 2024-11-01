<?php

namespace App\Livewire\Mahasiswa\Profil;

use Livewire\Component;
use Auth;
use Hash;
use App\Models\Mahasiswa;
use App\Models\Prodi;

class Index extends Component
{
    public $nim;
    public $nama;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $agama;
    public $alamat;
    public $jenis_pendaftaran;
    public $no;
    public $prodi;
    public $NIM;
    public $currentPassword = '';
    public $newPassword = '';
    public $confirmPassword = '';

    public function mount()
    {
        $mahasiswa = Mahasiswa::where('NIM', Auth()->user()->nim_nidn)->first();
        $this->nim = $mahasiswa->NIM ?? null;
        $this->nama = $mahasiswa->nama;
        $this->tempat_lahir = $mahasiswa->tempat_lahir;
        $this->tanggal_lahir = $mahasiswa->tanggal_lahir;
        $this->agama = $mahasiswa->agama;
        $this->alamat = $mahasiswa->alamat;
        $this->jenis_pendaftaran = $mahasiswa->jalur_pendaftaran;
        $this->no = $mahasiswa->no_hp;
        $this->prodi = Prodi::where('kode_prodi', $mahasiswa->kode_prodi)->first()->nama_prodi;
        $this->NIM = $mahasiswa->NIM;
    }

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

                    $this->dispatch('updated', ['message' => 'Password Updated Successfully']);
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
        return view('livewire.mahasiswa.profil.index');
    }
}
