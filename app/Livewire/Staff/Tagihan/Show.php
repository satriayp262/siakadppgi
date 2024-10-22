<?php

namespace App\Livewire\Staff\Tagihan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tagihan;
use App\Models\Semester;
use App\Models\Prodi;
use App\Models\Mahasiswa;

class Show extends Component
{
    public $search = '';
    public function render()
    {
        $Prodis = Prodi::all();
        $mahasiswas = Mahasiswa::query()
            ->whereHas('tagihan')
            ->where('nama', 'like', '%' . $this->search . '%')
            ->latest()
            ->paginate(24);
        $semesters = Semester::all();
        $nimList = $mahasiswas->pluck('NIM')->toArray(); // Mengambil array dari NIM mahasiswa

        // Ambil tagihan berdasarkan NIM yang ada di dalam $nimList
        $tagihans = Tagihan::query()
            ->whereIn('NIM', $nimList)
            ->select('NIM', 'id_tagihan')
            ->distinct()
            ->get(); // get() karena paginate tidak diperlukan di sini
        return view('livewire.staff.tagihan.show', [
            'semesters' => $semesters,
            'tagihans' => $tagihans,
            'mahasiswas' => $mahasiswas,
            'Prodis' => $Prodis,
        ]);
    }
}
