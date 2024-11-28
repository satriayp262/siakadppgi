<?php

namespace App\Livewire\Dosen\Presensi;

use Livewire\Component;
use App\Models\Matakuliah;
use Livewire\WithPagination;

class Absensi extends Component
{
    use WithPagination;
    public $search = '';

    public function render()
    {
        $presensiByMatkul = Matakuliah::where('nidn', auth()->user()->nim_nidn)
        ->when($this->search, function ($query) {
            $query->where('kode_mata_kuliah', 'like', '%' . $this->search . '%')
                ->orWhere('nama_mata_kuliah', 'like', '%' . $this->search . '%');
        })
        ->latest()
        ->paginate(10);

        return view('livewire.dosen.presensi.absensi',[
            'presensiByMatkul' => $presensiByMatkul,
        ]);
    }
}
