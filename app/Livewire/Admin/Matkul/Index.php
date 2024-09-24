<?php

namespace App\Livewire\Admin\Matkul;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Matkul;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    #[On('matkulUpdated')]
    public function handlematkulEdited()
    {
        session()->flash('message', 'matkul Updated Successfully');
    }

    public function destroy($id_mata_kuliah)
    {
        $matkul = Matkul::find($id_mata_kuliah);

            // Hapus data matkul
            $matkul->delete();

            // Tampilkan pesan sukses
            session()->flash('message', 'matkul destroyed successfully.');
    }

    #[On('matkulCreated')]
    public function handlematkulCreated()
    {
        session()->flash('message', 'matkul Created Successfully');
    }

    public function render()
    {
        $matkuls = Matkul::query()
            ->where('kode_mata_kuliah', 'like', '%' . $this->search . '%')
            ->orWhere('nama_mata_kuliah', 'like', '%' . $this->search . '%')
            ->orWhere('jenis_mata_kuliah', 'like', '%' . $this->search . '%')
            ->orWhere('metode_pembelajaran', 'like', '%' . $this->search . '%')
            ->orWhere('tgl_mulai_efektif', 'like', '%' . $this->search . '%')
            ->orWhere('tgl_akhir_efektif', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(10);

        return view('livewire.admin.matkul.index', [
            'matkuls' => $matkuls,
        ]);
    }
}