<?php

namespace App\Livewire\Admin\Ruangan;

use Livewire\Component;
use App\Models\Ruangan;
use Livewire\Attributes\On;

class Index extends Component
{
    public $search = '';
    public $selectedRuangan = [];
    public $selectAll = false;
    public $showDeleteButton = false;

    #[On('ruanganUpdated')]
    public function handleRuanganEdited()
    {
        $this->dispatch('updated', ['message' => 'Ruangan Berhasil diedit']);

    }

    public function updatedSelectAll($value)
    {
        if ($value) {

            $this->selectedRuangan = Ruangan::pluck('id_ruangan')->toArray();
        } else {

            $this->selectedRuangan = [];
        }
    }

    public function updatedselectedRuangan()
    {

        $this->showDeleteButton = count($this->selectedRuangan) > 0;
    }

    public function destroySelected()
    {
        // Hapus data Ruangan yang terpilih
        Ruangan::whereIn('id_ruangan', $this->selectedRuangan)->delete();

        // Reset array selectedRuangan setelah penghapusan
        $this->selectedRuangan = [];
        $this->selectAll = false; // Reset juga selectAll
        $this->dispatch('destroyed', ['message' => 'Ruangan Berhasil dihapus']);
        $this->showDeleteButton = false;
    }


    public function destroy($id_ruangan)
    {
        $ruangan = Ruangan::find($id_ruangan);
        $ruangan->delete();
        $this->dispatch('destroyed', params: ['message' => 'Ruangan deleted Successfully']);

    }

    #[On('ruanganCreated')]
    public function handleRuanganCreated()
    {
        $this->dispatch('created', ['message' => 'Ruangan Created Successfully']);

    }
    public function render()
    {
        $ruangans = Ruangan::orderByRaw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(kode_ruangan, '.', 2), '.', -1) AS UNSIGNED), CAST(SUBSTRING_INDEX(kode_ruangan, '.', -1) AS UNSIGNED)")
            ->paginate(perPage: 10);

        return view('livewire.admin.ruangan.index', [
            'ruangans' => $ruangans
        ]);
    }
}
