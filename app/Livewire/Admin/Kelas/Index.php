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
    public $selectedKelas = [];
    public $selectAll = false;
    public $showDeleteButton = false;

    #[On('kelasCreated')]
    public function handleKelasCreated()
    {
        $this->dispatch('created', ['message' => 'Kelas Berhasil Disimpan']);
    }


    #[On('kelasUpdated')]
    public function handleKelasUpdated()
    {
        $this->dispatch('updated', ['message' => 'Kelas Berhasil Diupdate']);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Jika selectAll true, pilih semua id_dosen
            $this->selectedKelas = Kelas::pluck('id_kelas')->toArray();
        } else {
            // Jika selectAll false, hapus semua pilihan
            $this->selectedKelas = [];
        }
    }

    public function updatedSelectedKelas()
    {
        // Jika ada dosen yang dipilih, tampilkan tombol, jika tidak, sembunyikan
        $this->showDeleteButton = count($this->selectedKelas) > 0;
    }
    public function destroySelected()
    {
        // Hapus data dosen yang terpilih
        Kelas::whereIn('id_kelas', $this->selectedKelas)->delete();

        // Reset array selectedDosen setelah penghapusan
        $this->selectedKelas = [];
        $this->selectAll = false; // Reset juga selectAll

        // Emit event ke frontend untuk reset checkbox
        $this->dispatch('kelasDeleted');
    }


    public function destroy($id_kelas)
    {
        $kelas = Kelas::find($id_kelas);

        // Hapus data kelas
        $kelas->delete();

        $this->dispatch('destroyed', params: ['message' => 'Kelas deleted Successfully']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $kelases = Kelas::query()
            ->Where('nama_kelas', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(5);

        return view('livewire.admin.kelas.index', [
            'kelases' => $kelases,
        ]);
    }
}
