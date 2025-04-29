<?php

namespace App\Livewire\Admin\PaketKrs;

use App\Models\paketKRS;
use Livewire\Component;

class Index extends Component
{
    public function destroy($id)
    {
        $x = paketKRS::find($id);
        $paketKRS = paketKRS::where('id_semester', $x->id_semester)->where('id_kelas', $x->id_kelas)->get();
        foreach ($paketKRS as $p) {
            $p->delete();
        }
        $this->dispatch('deletedPaketKRS', ['message' => 'Paket KRS deleted Successfully']);
    }
    public function render()
    {
        $paketKRS = paketKRS::whereIn(
            'id_paket_krs',
            paketKRS::selectRaw('MIN(id_paket_krs) as id_paket_krs')
                ->groupBy('id_semester', 'id_prodi', 'id_kelas')
        )->latest()
            ->paginate(10);
        return view('livewire.admin.paket-krs.index', [
            'paketKRS' => $paketKRS
        ]);
    }
}
