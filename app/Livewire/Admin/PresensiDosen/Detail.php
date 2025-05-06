<?php

namespace App\Livewire\Admin\PresensiDosen;

use Livewire\Component;
use App\Models\BeritaAcara;
use App\Models\Kelas;
use App\Models\Matakuliah;
use App\Models\Semester;
use Livewire\WithPagination;

class Detail extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedMatkul = '';
    public $selectedKelas = '';
    public $selectedSemester = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $beritaAcaras = BeritaAcara::with(['kelas', 'mataKuliah', 'dosen'])
            ->when($this->selectedMatkul, function ($query) {
                $query->whereHas('mataKuliah', function ($q) {
                    $q->where('kode_mata_kuliah', $this->selectedMatkul);
                });
            })
            ->when($this->selectedKelas, function ($query) {
                $query->where('kelas', $this->selectedKelas);
            })
            ->when($this->selectedSemester, function ($query) {
                $query->where('semester', $this->selectedSemester);
            })
            ->paginate(10);

        $matkuls = Matakuliah::pluck('kode_mata_kuliah', 'nama_mata_kuliah');
        $kelasList = Kelas::pluck('nama_kelas', 'id_kelas');
        $semesters = Semester::pluck('nama_semester', 'id_semester');

        return view('livewire.admin.presensi-dosen.detail', [
            'beritaAcaras' => $beritaAcaras,
            'matkuls' => $matkuls,
            'kelasList' => $kelasList,
            'semesters' => $semesters,
        ]);
    }
}
