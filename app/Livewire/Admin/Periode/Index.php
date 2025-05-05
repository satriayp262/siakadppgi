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
        $this->dispatch('created', ['message' => 'Periode Berhasil di Tambahkan']);
        return redirect()->route('admin.emonev.periode');
    }

    public function destroySelected($ids): void
    {
        PeriodeEMonev::whereIn('id_periode', $ids)->delete();
        $this->deleted();
    }

    public function destroy($id)
    {
        $periode = PeriodeEMonev::find($id);
        if ($periode) {
            $periode->delete();
            $this->dispatch('pg: eventRefresh - periode - table - hwo90b - table');
        } else {
            $this->dispatch('error', ['message' => 'Periode tidak ditemukan']);
        }
    }


    public function render()
    {
        $periode = PeriodeEMonev::with('semester')->paginate(10);
        return view('livewire.admin.periode.index', [
            'periode' => $periode
        ]);
    }
}
