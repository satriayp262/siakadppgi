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


    public function render()
    {
        $periode = PeriodeEMonev::with('semester')->get();
        return view('livewire.admin.periode.index', [
            'periode' => $periode
        ]);
    }
}
