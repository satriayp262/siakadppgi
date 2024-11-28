<?php

namespace App\Livewire\Dosen\BeritaAcara;

use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Livewire\WithPagination;

class DetailMatkul extends Component
{
    use WithPagination;

    public $matkul, $CheckDosen = false;

    public function mount($id_mata_kuliah)
    {
        // Ambil data mata kuliah berdasarkan id_mata_kuliah
        $this->matkul = Matakuliah::findOrFail($id_mata_kuliah);

    }

    public function render()
    {
        $kelas = Kelas::with('matkul')
            ->where('id_mata_kuliah', $this->matkul->id_mata_kuliah) // Gunakan $this->matkul->id_mata_kuliah
            ->paginate(10);

            $this->CheckDosen = (Auth()->user()->nim_nidn == Matakuliah::where('id_mata_kuliah', $this->matkul->id_mata_kuliah)->first()->nidn);

        return view('livewire.dosen.berita_acara.detail-matkul', [
            'kelas' => $kelas,
        ]);
    }
}
