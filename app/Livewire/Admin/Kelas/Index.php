<?php

namespace App\Livewire\Admin\Kelas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Kelas;

class Index extends Component
{

    use WithPagination;
    public $search = '';

    // public function destroy($kode_kelas)
    // {
    //     $kelas = Kelas::find($kode_kelas);

    //     // Hapus data kelas
    //     $kelas->delete();

    //     // Tampilkan pesan sukses
    //     session()->flash('message', 'Kelas Berhasil di Hapus');
    //     session()->flash('message_type', 'error');
    // }




    public function render()
    {
        $kelas = Kelas::query()
            ->where('kode_kelas', 'like', '%' . $this->search . '%')
            ->orWhere('nama_kelas', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);
        return view('livewire.admin.kelas.index', [
            'kelas' => $kelas,
        ]);
    }
}
