<?php

namespace App\Livewire\Dosen\BeritaAcara;

use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Livewire\WithPagination;

class DetailMatkul extends Component
{
    use WithPagination;

    public $matkul;

    public function mount($id_mata_kuliah)
    {
        // Ambil data mata kuliah berdasarkan id_mata_kuliah
        $this->matkul = Matakuliah::findOrFail($id_mata_kuliah);
    }

    public function render()
    {
        // Query kelas berdasarkan id_mata_kuliah yang dipilih
        $kelas = Kelas::where('id_mata_kuliah', $this->matkul->id_mata_kuliah)
            ->paginate(5);

        return view('livewire.dosen.berita_acara.detail-matkul', [
            'kelas' => $kelas,
        ]);
    }
}
