<?php

namespace App\Livewire\Dosen\BeritaAcara;

use Livewire\Component;
use App\Models\Matakuliah;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        $beritaAcaraByMatkul = Matakuliah::where('nidn', auth()->user()->nim_nidn)
            ->when($this->search, function ($query) {
                $query->where('kode_mata_kuliah', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_mata_kuliah', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.dosen.berita_acara.index', [
            'beritaAcaraByMatkul' => $beritaAcaraByMatkul,
        ]);
    }
}
