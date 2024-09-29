<?php

namespace App\Livewire\Admin\Kelas;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Kelas;
use Livewire\Attributes\On;

class Index extends Component
{

    use WithPagination;

    public $search = '';

    #[On('kelasCreated')]
    public function handleKelasCreated()
    {
        session()->flash('message', 'Kelas Berhasil di Tambahkan');
        session()->flash('message_type', 'success');
    }


    #[On('kelasUpdated')]
    public function handleKelasUpdated()
    {
        session()->flash('message', 'Kelas Berhasil di Update');
        session()->flash('message_type', 'warning');
    }




    public function destroy($id_kelas)
    {
        $kelas = Kelas::find($id_kelas);

        // Hapus data kelas
        $kelas->delete();

        // Tampilkan pesan sukses
        session()->flash('message', 'Kelas Berhasil di Hapus');
        session()->flash('message_type', 'error');
    }

    public function render()
    {
        $kelases = Kelas::query()
            ->where('kode_kelas', 'like', '%' . $this->search . '%')
            ->orWhere('nama_kelas', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);

        return view('livewire.admin.kelas.index', [
            'kelases' => $kelases,
        ]);
    }
}
