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
        session()->flash('message', 'Dosen Updated Successfully');
    }

    public function destroy($id_dosen)
    {
        $dosen = Dosen::find($id_dosen);

            // Hapus data dosen
            $dosen->delete();

            // Tampilkan pesan sukses
            session()->flash('message', 'Dosen destroyed successfully.');
    }

    #[On('dosenCreated')]
    public function handledosenCreated()
    {
            session()->flash('message', 'Dosen created successfully.');
    }

    public $id_dosen, $nama_dosen, $nidn, $jenis_kelamin, $jabatan_fungsional, $kepangkatan, $kode_prodi;
    public function render()
    {
        $dosen = Dosen::all();
        return view('livewire.admin.dosen.index', compact('dosen'));
    }
}
