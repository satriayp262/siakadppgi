<?php

namespace App\Livewire\Dosen\Presensi;

use Livewire\Component;
use App\Models\Matakuliah;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $search = '';

    public function render()
    {
        // Fetching mata kuliah data based on NIDN of the authenticated user
        $presensiByMatkul = Matakuliah::where('nidn', auth()->user()->nim_nidn)
            ->when($this->search, function ($query) {
                $query->where('kode_mata_kuliah', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_mata_kuliah', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        // Return the data to the view
        return view('livewire.dosen.presensi.index', [
            'presensiByMatkul' => $presensiByMatkul,
        ]);
    }
}
