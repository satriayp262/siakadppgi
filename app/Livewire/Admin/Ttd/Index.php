<?php

namespace App\Livewire\Admin\Ttd;

use App\Models\ttd;
use Livewire\Component;
use Livewire\Attributes\On;

class Index extends Component
{
    public function destroySelected($ids): void
    {
        ttd::whereIn('id_ttd', $ids)->delete();

        $this->dispatch('pg:eventRefresh-ttd-table-rsed3p-table');
        $this->dispatch('destroyed', ['message' => 'Tanda Tangan Berhasil dihapus']);

    }

    #[On('ttdUpdated')]
    public function handlettdEdited()
    {
        $this->dispatch('pg:eventRefresh-ttd-table-rsed3p-table');

        $this->dispatch('updated', ['message' => 'Tanda Tangan Edited Successfully']);

    }

    public function destroy($id_ttd)
    {
        $ttd = ttd::find($id_ttd);
        $ttd->delete();
        $this->dispatch('pg:eventRefresh-ttd-table-rsed3p-table');

        $this->dispatch('destroyed', params: ['message' => 'Tanda Tangan deleted Successfully']);


    }

    #[On('ttdCreated')]
    public function handlettdCreated()
    {
        $this->dispatch('pg:eventRefresh-ttd-table-rsed3p-table');
        $this->dispatch('created', ['message' => 'Tanda Tangan Created Successfully']);


    }
    public function render()
    {
        return view('livewire.admin.ttd.index');
    }
}
