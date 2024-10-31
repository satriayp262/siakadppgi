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
        session()->flash('message', 'Kelas Berhasil di Tambahkan');
        session()->flash('message_type', 'success');
    }


    #[On('kelasUpdated')]
    public function handleKelasUpdated()
    {
        session()->flash('message', 'Kelas Berhasil di Update');
        session()->flash('message_type', 'update');
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

        // Tampilkan pesan sukses
        session()->flash('message', 'Kelas Berhasil di Hapus');
        session()->flash('message_type', 'error');
    }

    public function updatedSearch()
    {
        $this->resetPage();
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
