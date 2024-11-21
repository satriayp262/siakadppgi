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

    public function mount(Matakuliah $matkul)
    {
        $this->matkul = $matkul;
    }

    public function render()
    {
        // Query kelas berdasarkan id_mata_kuliah dengan pagination
        $kelas = Kelas::where('id_mata_kuliah', $this->matkul->id)
            ->paginate(5); // Anda bisa mengatur jumlah item per halaman

        return view('livewire.dosen.berita_acara.detail-matkul', [
            'matkul' => $this->matkul,
            'kelas' => $kelas,
        ]);
    }
}
