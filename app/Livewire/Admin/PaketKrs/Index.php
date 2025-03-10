<?php

namespace App\Livewire\Admin\PaketKrs;

use App\Models\paketKRS;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        $paketKRS = paketKRS::whereIn(
            'id_paket_krs',
            paketKRS::selectRaw('MIN(id_paket_krs) as id_paket_krs')
                ->groupBy('id_semester', 'id_prodi', 'id_kelas')
        )
            ->paginate(10);



        return view('livewire.admin.paket-krs.index', [
            'paketKRS' => $paketKRS
        ]);
    }
}
