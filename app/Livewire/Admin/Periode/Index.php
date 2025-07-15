<?php

namespace App\Livewire\Admin\Periode;

use App\Models\Emonev;
use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PeriodeEMonev;

class Index extends Component
{
    public $selectedPeriode = [];
    public $ini = true;

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
        $this->dispatch('confirm-create-pengumuman');
    }

    public function destroySelected($ids): void
    {
        $periode = PeriodeEMonev::find($ids);
        $emonev = Emonev::whereIn('nama_periode', $periode->pluck('nama_periode'))->count();

        if ($emonev != 0) {
            $this->dispatch('warning', ['message' => 'Periode tidak bisa dihapus karena sudah ada data emonev yang terkait']);
            return;
        }
        PeriodeEMonev::whereIn('id_periode', $ids)->delete();
        $this->dispatch('pg:eventRefresh-periode-table-hwo90b-table');
        $this->dispatch('destroyed', ['message' => 'Periode Berhasil di Hapus']);
    }

    public function destroy($id)
    {
        $periode = PeriodeEMonev::find($id);
        $emonev = Emonev::whereIn('nama_periode', $periode->pluck('nama_periode'))->count();

        if ($emonev != 0) {
            $this->dispatch('warning', ['message' => 'Periode tidak bisa dihapus karena sudah ada data emonev yang terkait']);
            return;
        }
        $periode->delete();
        $this->dispatch('pg:eventRefresh-periode-table-hwo90b-table');
        $this->dispatch('destroyed', ['message' => 'Periode Berhasil di Hapus']);

    }

    public function kirim()
    {
        return redirect()->route('admin.pengumuman');
    }


    public function render()
    {
        $this->dispatch('openKirimModal');
        $periode = PeriodeEMonev::with('semester')->paginate(10);
        return view('livewire.admin.periode.index', [
            'periode' => $periode,
        ]);
    }
}
