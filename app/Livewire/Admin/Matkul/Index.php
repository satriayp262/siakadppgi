<?php

namespace App\Livewire\Admin\Matkul;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Matakuliah;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    #[On('matkulUpdated')]
    public function handlematkulEdited()
    {
        session()->flash('message', 'Mata Kuliah Berhasil di Update');
        session()->flash('message_type', 'warning');
    }

    public function destroy($id_mata_kuliah)
    {
        $matkul = Matakuliah::find($id_mata_kuliah);

            // Hapus data matkul
            $matkul->delete();

            // Tampilkan pesan sukses
            session()->flash('message', 'Mata Kuliah Berhasil di Hapus');
            session()->flash('message_type', 'error');
    }

    #[On('matkulCreated')]
    public function handlematkulCreated()
    {
        session()->flash('message', 'Mata Kuliah Berhasil di Tambahkan');
        session()->flash('message_type', 'success');
    }

    #[On('matkulImported')]
    public function handlematkulImported()
    {
        session()->flash('message', 'Mata Kuliah Berhasil di Import');
        session()->flash('message_type', 'success');
    }

    public function render()
    {
        $matkuls = Matakuliah::query()
            ->where('kode_mata_kuliah', 'like', '%' . $this->search . '%')
            ->orWhere('nama_mata_kuliah', 'like', '%' . $this->search . '%')
            ->orWhere('jenis_mata_kuliah', 'like', '%' . $this->search . '%')
            ->orWhere('metode_pembelajaran', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);

        return view('livewire.admin.matkul.index', [
            'matkuls' => $matkuls,
        ]);
    }
}