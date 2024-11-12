<?php

namespace App\Livewire\Admin\Ruangan;

use Livewire\Component;
use App\Models\Ruangan;
use Livewire\Attributes\On;

class Index extends Component
{
    #[On('ruanganUpdated')]
    public function handleRuanganEdited()
    {
        $this->dispatch('updated', ['message' => 'Ruangan Edited Successfully']);

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
            ->paginate(20);

        return view('livewire.admin.ruangan.index', [
            'ruangans' => $ruangans
        ]);
    }
}
