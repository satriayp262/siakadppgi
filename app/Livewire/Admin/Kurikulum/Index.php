<?php

namespace App\Livewire\Admin\Kurikulum;

use Livewire\Component;
use App\Models\Kurikulum;
use App\Models\Prodi;
use Livewire\Attributes\On;
use App\Models\Semester;

class Index extends Component
{
    public $id_kurikulum;
    public $selectedKurikulum = [];
    public $selectAll = false;
    public $showDeleteButton = false;


    #[On('KurikulumCreated')]
    public function handleKurikulumCreated()
    {
        $this->dispatch('created', ['message' => 'Kurikulum Berhasil Ditambahkan']);
    }

    #[On('KurikulumUpdated')]
    public function handleKurikulumUpdated()
    {
        $this->dispatch('updated', ['message' => 'Kurikulum Berhasil Diubah']);
    }

    public function destroy($id_kurikulum)
    {
        $kurikulum = Kurikulum::find($id_kurikulum);
        $kurikulum->delete();

        $this->dispatch('deleted', ['message' => 'Kurikulum Berhasil Dihapus']);
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            // Jika selectAll true, pilih semua id_kurikulum
            $this->selectedKurikulum = Kurikulum::pluck('id_kurikulum')->toArray();
        } else {
            // Jika selectAll false, hapus semua pilihan
            $this->selectedKurikulum = [];
        }
    }

    public function updatedSelectedKurikulum()
    {
        // Jika ada kurikulum yang dipilih, tampilkan tombol, jika tidak, sembunyikan
        $this->showDeleteButton = count($this->selectedKurikulum) > 0;
    }

    public function destroySelected()
    {
        // Hapus data kurikulum yang terpilih
        Kurikulum::whereIn('id_kurikulum', $this->selectedKurikulum)->delete();

        // Reset array selectedKurikulum setelah penghapusan
        $this->selectedKurikulum = [];
        $this->selectAll = false; // Reset juga selectAll

        // Emit event ke frontend untuk reset checkbox
        $this->dispatch('kurikulumDeleted');
    }

    public function render()
    {
        $kurikulums = Kurikulum::all();
        $prodis = Prodi::all();
        $semesters = Semester::all();

        return view('livewire.admin.kurikulum.index', [
            'kurikulums' => $kurikulums,
            'prodis' => $prodis,
            'semesters' => $semesters
        ]);
    }
}
