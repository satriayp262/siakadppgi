<?php

namespace App\Livewire\Admin\Periode;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PeriodeEMonev;

class Index extends Component
{
    public $selectedPeriode = [];

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedPeriode = PeriodeEMonev::pluck('id_emonev')->toArray();
        } else {
            $this->selectedPeriode = [];
        }
    }

    #[On('PeriodeCreated')]
    public function handlePeriodeCreated()
    {
        $this->dispatch('pg:eventRefresh-periode-table-hwo90b-table');
        $this->dispatch('created', ['message' => 'Periode Berhasil di Tambahkan']);
    }

    public function destroySelected($ids): void
    {
        PeriodeEMonev::whereIn('id_periode', $ids)->delete();
        $this->dispatch('pg:eventRefresh-periode-table-hwo90b-table');
        $this->dispatch('destroyed', ['message' => 'Periode Berhasil di Hapus']);
    }

    public function destroy($id)
    {
        $periode = PeriodeEMonev::find($id);
        $periode->delete();
        $this->dispatch('pg:eventRefresh-periode-table-hwo90b-table');
        $this->dispatch('destroyed', ['message' => 'Periode Berhasil di Hapus']);
    }


    public function render()
    {
        $periode = PeriodeEMonev::with('semester')->paginate(10);
        return view('livewire.admin.periode.index', [
            'periode' => $periode
        ]);
    }
}
