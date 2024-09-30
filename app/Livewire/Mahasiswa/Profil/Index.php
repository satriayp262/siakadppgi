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
    public $currentPassword;
    public $newPassword;
    public $confirmPassword;

    public function mount()
    {
        $user = Auth::user();
        $mahasiswa = mahasiswa::where('id', $user->id)->first();
        $this->nim = $mahasiswa->NIM;
        $this->nama = $mahasiswa->nama;
        $this->tempat_lahir = $mahasiswa->tempat_lahir;
        $this->tanggal_lahir = $mahasiswa->tanggal_lahir;
        $this->agama = $mahasiswa->agama;
        $this->alamat = $mahasiswa->alamat;
        $this->jenis_pendaftaran = $mahasiswa->jalur_pendaftaran;
        $this->no = $mahasiswa->no_hp;
        $this->prodi = Prodi::where('kode_prodi', $mahasiswa->kode_prodi)->first()->nama_prodi;
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
                    session()->flash('message', 'Password baru tidak boleh sama dengan password lama');
                    session()->flash('message_type', 'error');
                }else{
                    $user->update([
                        'password' => Hash::make($this->newPassword),
                    ]);
    
                    session()->flash('message', 'Password Berhasil direset');
                    session()->flash('message_type', 'success');
                }
            } else {
                session()->flash('message', 'Password baru tidak sama');
                session()->flash('message_type', 'error');
            }
        } else {
            session()->flash('message', 'Password lama salah');
            session()->flash('message_type', 'error');
        }

        $this->currentPassword = null;
        $this->newPassword = null;
        $this->confirmPassword = null;

    }

    public function render()
    {
        return view('livewire.mahasiswa.profil.index');
    }
}
