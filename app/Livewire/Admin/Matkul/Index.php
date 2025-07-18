<?php

namespace App\Livewire\Admin\Matkul;

use App\Exports\MatkulExport;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Matakuliah;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TemplateExport; // Pastikan TemplateExport sudah dibuat
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use App\Imports\MatkulImport;


class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedMatkul = [];
    public $selectAll = false;
    public $showDeleteButton = false;

    #[On('matkulUpdated')]
    public function handlematkulEdited()
    {
        $this->dispatch('pg:eventRefresh-matkul-gsy2i9-table');
        $this->dispatch('updated', ['message' => 'Matakuliah Edited Successfully']);
    }


    public function destroy($id_mata_kuliah)
    {
        $matkul = Matakuliah::find($id_mata_kuliah);

        // Hapus data matkul
        $matkul->delete();

        // Tampilkan pesan sukses
        $this->dispatch('pg:eventRefresh-matkul-gsy2i9-table');
        $this->dispatch('destroyed', ['message' => 'Matakuliah Deleted Successfully']);
    }

    #[On('matkulCreated')]
    public function handlematkulCreated()
    {
        $this->dispatch('pg:eventRefresh-matkul-gsy2i9-table');
        $this->dispatch('created', ['message' => 'Matkul Created Successfully']);
    }

    #[On('matkulImported')]
    public function handlematkulImported($data)
    {
        $existingRows = $data['existingRows'];
        $addedRows = $data['addedRows'];
        $errors = $data['errors'];
        $editedRows = $data['editedRows'];

        if (!empty($existingRows)) {
            session()->flash('message2', count($existingRows) . ' Data sudah ada: <br>' . implode('', $existingRows));
            session()->flash('message_type2', 'warning');
        }

        if (!empty($editedRows)) {
            // Flash message showing the count of edited rows and details
            $editedRowsMessage = count($editedRows) . ' Data berhasil diupdate: <br>' . implode('', $editedRows);
            session()->flash('message2', $editedRowsMessage);
            session()->flash('message_type2', 'info');
        }

        if (!empty($errors)) {
            // Flash message showing the count of errors and details
            $errorsMessage = count($errors) . ' Data gagal ditambahkan: <br>' . implode('', $errors);
            session()->flash('message2', $errorsMessage);
            session()->flash('message_type2', 'error');
        }

        if (!empty($addedRows)) {
            session()->flash('message', count($addedRows) . ' Data berhasil ditambahkan: <br>' . implode('', $addedRows));
            session()->flash('message_type', 'success');
        } else {
            session()->flash('message', 'Tidak ada mata kuliah yang ditambahkan');
            session()->flash('message_type', 'error');
        }
        $this->dispatch('pg:eventRefresh-matkul-gsy2i9-table');
        // dd(session()->all());
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Jika selectAll true, pilih semua id_dosen
            $this->selectedMatkul = Matakuliah::pluck('id_mata_kuliah')->toArray();
        } else {
            // Jika selectAll false, hapus semua pilihan
            $this->selectedMatkul = [];
        }
    }

    public function updatedSelectedMatkul()
    {
        // Jika ada dosen yang dipilih, tampilkan tombol, jika tidak, sembunyikan
        $this->showDeleteButton = count($this->selectedMatkul) > 0;
    }

    public function destroySelected()
    {
        $this->dispatch('pg:eventRefresh-matkul-gsy2i9-table');
        $this->dispatch('destroyed', ['message' => 'Matakuliah Deleted Successfully']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $matkuls = Matakuliah::query()
            ->where('kode_mata_kuliah', 'like', '%' . $this->search . '%')
            ->orWhere('nama_mata_kuliah', 'like', '%' . $this->search . '%')
            ->orWhereHas('prodi', function ($query) {
                $query->where('nama_prodi', 'like', '%' . $this->search . '%');
            })
            ->orWhereHas('dosen', function ($query) {
                $query->where('nama_dosen', 'like', '%' . $this->search . '%');
            })
            ->orWhere('jenis_mata_kuliah', 'like', '%' . $this->search . '%')
            ->orWhere('metode_pembelajaran', 'like', '%' . $this->search . '%')
            ->orderBy('kode_mata_kuliah')
            ->paginate(10);

        return view('livewire.admin.matkul.index', [
            'matkuls' => $matkuls,
        ]);
    }
}
