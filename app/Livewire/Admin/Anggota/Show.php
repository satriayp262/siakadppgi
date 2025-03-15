<?php

namespace App\Livewire\Admin\Anggota;

use App\Models\Kelas;
use App\Models\Mahasiswa;
use Livewire\Component;
use Livewire\Attributes\On;

class Show extends Component
{

    public $nama_kelas;
    public function destroy($id_mahasiswa)
    {
        if (!(str_replace('-', '/', $this->nama_kelas) == 'Tanpa kelas')){
            $mahasiswa = Mahasiswa::find($id_mahasiswa);
            $mahasiswa->id_kelas = null;
            $mahasiswa->save();
            $this->dispatch('AnggotaDestroyed', params: ['message' => 'Mahasiswa telah dihapus dari kelas Ini']);
        }else{
            $this->dispatch('AnggotaDestroyed', params: ['message' => 'Error!']);
        }
    }

    #[On('AnggotaUpdatedSuccess')]
    public function handleAnggotaUpdatedSuccess()
    {
        $this->dispatch('AnggotaUpdated', params: ['message' => 'Mahasiswa berhasil di Update']);

    }

    public function render()
    {
        if (!(str_replace('-', '/', $this->nama_kelas) == 'Tanpa kelas')) {
            $kelas = Kelas::where('nama_kelas', str_replace('-', '/', $this->nama_kelas))->first();
            $mahasiswa = Mahasiswa::where('id_kelas', $kelas->id_kelas)->get();
        }else{
            $mahasiswa = Mahasiswa::where('id_kelas', null)->paginate(10);
        }
        return view('livewire.admin.anggota.show', [
            'mahasiswa' => $mahasiswa,
        ]);
    }
}
