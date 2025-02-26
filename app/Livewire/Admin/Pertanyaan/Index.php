<?php

namespace App\Livewire\Admin\Pertanyaan;

use Livewire\Component;
use App\Models\Pertanyaan;
use Livewire\WithPagination;
use App\Models\PeriodeEMonev;
use Livewire\Attributes\On;

class Index extends Component
{
    use WithPagination;

    public $selectedPertanyaan = [];
    public $selectAll = false;
    public $showDeleteButton = false;

    #[On('PertanyaanCreated')]
    public function handlePertanyaanCreated()
    {
        $this->dispatch('created', ['message' => 'Pertanyaan Berhasil di Tambahkan']);
    }

    #[On('PertanyaanUpdated')]
    public function handlePertanyaanUpdated()
    {
        $this->dispatch('created', ['message' => 'Pertanyaan Berhasil di Perbaharui']);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Jika selectAll true, pilih semua id_dosen
            $this->selectedPertanyaan = Pertanyaan::pluck('id_pertanyaan')->toArray();
        } else {
            // Jika selectAll false, hapus semua pilihan
            $this->selectedPertanyaan = [];
        }
    }

    public function updatedSelectedPertanyaan()
    {
        // Jika ada dosen yang dipilih, tampilkan tombol, jika tidak, sembunyikan
        $this->showDeleteButton = count($this->selectedPertanyaan) > 0;
    }

    public function destroySelected()
    {
        Pertanyaan::whereIn('id_pertanyaan', $this->selectedPertanyaan)->delete();

        // Reset array selectedDosen setelah penghapusan
        $this->selectedPertanyaan = [];
        $this->selectAll = false; // Reset juga selectAll

        $this->dispatch('destroyed', ['message' => 'Pertanyaan Berhasil Dihapus']);
        $this->showDeleteButton = false;
    }

    public function destroy($id_pertanyaan)
    {
        $pertanyaan = Pertanyaan::find($id_pertanyaan);

        $pertanyaan->delete();

        $this->dispatch('destroyed', ['message' => 'Pertanyaan Berhasil di Hapus']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }





    public function render()
    {
        $pertanyaans = Pertanyaan::latest()->paginate(10);

        $periode = PeriodeEMonev::all();

        return view('livewire.admin.pertanyaan.index', [
            'pertanyaans' => $pertanyaans
        ]);
    }
}
