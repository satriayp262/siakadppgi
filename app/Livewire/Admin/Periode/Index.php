<?php

namespace App\Livewire\Admin\Periode;

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\PeriodeEMonev;

class Index extends Component
{

    #[On('PeriodeCreated')]
    public function handlePeriodeCreated()
    {
        $this->dispatch('created', ['message' => 'Periode Berhasil di Tambahkan']);
    }

    public function destroy($id)
    {
        $periode = PeriodeEMonev::find($id);
        if ($periode) {
            $periode->delete();
            $this->dispatch('deleted', ['message' => 'Periode Berhasil di Hapus']);
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
