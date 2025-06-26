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
        $nidn = auth()->user()->nim_nidn;
        $query = Matakuliah::where('nidn', $nidn);

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('kode_mata_kuliah', 'like', '%' . $this->search . '%')
                    ->orWhere('nama_mata_kuliah', 'like', '%' . $this->search . '%');
            });
        }

        $beritaAcaraByMatkul = $query->paginate(10);

        return view('livewire.dosen.berita_acara.index', [
            'beritaAcaraByMatkul' => $beritaAcaraByMatkul,
        ]);
    }
}
