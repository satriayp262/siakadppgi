<?php

namespace App\Livewire\Admin\Matkul;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Matakuliah;
use Livewire\Attributes\On;
use App\Imports\MatkulImport;

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
    public function handlematkulImported($data)
    {
        $existingRows = $data['existingRows'];
        $addedRows = $data['addedRows'];

        if (!empty($existingRows)) {
            session()->flash('message2', 'Baris dengan kode mata kuliah berikut sudah ada: ' . implode(', ', $existingRows));
            session()->flash('message_type2', 'warning');
        }

        if (!empty($addedRows)) {
            session()->flash('message', 'Baris dengan kode mata kuliah berikut berhasil ditambahkan: ' . implode(', ', $addedRows));
            session()->flash('message_type', 'success');
        }else{
            session()->flash('message', 'Tidak ada mata kuliah yang ditambahkan');
            session()->flash('message_type', 'error');
        }

        // dd(session()->all());
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