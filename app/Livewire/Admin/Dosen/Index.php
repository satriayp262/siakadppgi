<?php

namespace App\Livewire\Admin\Dosen;

use App\Models\Dosen;
use Livewire\WithPagination;
use Livewire\Component;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    #[On('dosenUpdated')]
    public function handledosenEdited()
    {
        session()->flash('message', 'Dosen Berhasil di Update');
    }

    public function destroy($id_dosen)
    {
        $dosen = Dosen::find($id_dosen);

            // Hapus data dosen
            $dosen->delete();

            // Tampilkan pesan sukses
            session()->flash('message', 'Dosen Berhasil di Hapus');
    }

    #[On('dosenCreated')]
    public function handledosenCreated()
    {
            session()->flash('message', 'Dosen Berhasil di Tambahkan');
    }

    public $id_dosen, $nama_dosen, $nidn, $jenis_kelamin, $jabatan_fungsional, $kepangkatan, $kode_prodi;
    public function render()
    {
        $dosens = Dosen::query()
            ->where('nama_dosen', 'like', '%' . $this->search . '%')
            ->orWhere('nidn', 'like', '%' . $this->search . '%')
            ->orWhere('jenis_kelamin', 'like', '%' . $this->search . '%')
            ->orWhere('jabatan_fungsional', 'like', '%' . $this->search . '%')
            ->orWhere('kepangkatan', 'like', '%' . $this->search . '%')
            ->orWhere('kode_prodi', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);

        return view('livewire.admin.dosen.index', [
            'dosens' => $dosens,
        ]);
    }
}
