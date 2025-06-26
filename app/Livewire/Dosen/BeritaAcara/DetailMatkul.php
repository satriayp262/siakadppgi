<?php

namespace App\Livewire\Dosen\BeritaAcara;

use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\KRS;

class DetailMatkul extends Component
{
    use WithPagination;

    public $matkul, $id_mata_kuliah, $url;
    public $search = '';

    public function mount($id_mata_kuliah)
    {
        // Ambil data mata kuliah berdasarkan id_mata_kuliah
        $this->matkul = Matakuliah::findOrFail($id_mata_kuliah);
    }

    public function render()
    {
        $this->url = request()->url();

        if (!$this->id_mata_kuliah) {
            return view('livewire.dosen.presensi.absensi-by-kelas', [
                'kelas' => collect(),
            ]);
        }

        $mataKuliah = MataKuliah::where('nidn', Auth()->user()->nim_nidn)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->first();

        $kelasEntries = KRS::where('id_mata_kuliah', $mataKuliah->id_mata_kuliah)
            ->distinct()
            ->pluck('id_kelas');

        $query = Kelas::whereIn('id_kelas', $kelasEntries);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('nama_kelas', 'like', '%' . $this->search . '%');
            });
        }

        $kelas = $query->distinct()->paginate(10);

        return view('livewire.dosen.berita_acara.detail-matkul', [
            'kelas' => $kelas,
        ]);
    }
}
