<?php

namespace App\Livewire\Admin\Kelas;

use Livewire\Component;
use App\Models\Kelas;

class Show extends Component
{

    public $id_kelas;

    public function mount($id_kelas)
    {
        $this->id_kelas = $id_kelas;
    }

    public function render()
    {
        $kelases = Kelas::find($this->id_kelas);
        return view('livewire.admin.kelas.show', [
            'kelases' => $kelases,
        ]);
    }
}
