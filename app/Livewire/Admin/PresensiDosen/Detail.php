<?php

namespace App\Livewire\Admin\PresensiDosen;

use Livewire\Component;
use App\Exports\BeritaAcaraExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\BeritaAcara;
use App\Models\Semester;
use App\Models\Kelas;
use App\Models\Matakuliah;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class Detail extends Component
{
    use WithPagination;

    #[Url]
    public $nidn;

    public $search = '';
    public $selectedMatkul = '';
    public $selectedKelas = '';
    public $selectedSemester = '';

    public $semesters;
    public $kelasList;
    public $matkuls;

    public function mount()
    {
        $this->semesters = Semester::orderBy('nama_semester')->get();
        $this->kelasList = Kelas::orderBy('nama_kelas')->get();
        $this->matkuls = Matakuliah::orderBy('nama_mata_kuliah')->get();
    }

    public function exportExcel()
    {
        return Excel::download(new BeritaAcaraExport(
            $this->nidn,
            $this->selectedSemester ?: 'semua',
            $this->selectedKelas ?: 'semua',
            $this->selectedMatkul ?: 'semua'
        ), 'berita_acara_export_' . $this->nidn . '_' . ($this->selectedSemester ?: 'semua') . '_' . ($this->selectedKelas ?: 'semua') . '_' . ($this->selectedMatkul ?: 'semua') . '.xlsx');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $beritaAcaras = BeritaAcara::with(['kelas', 'mataKuliah', 'dosen'])
            ->where('nidn', $this->nidn)
            ->when($this->selectedMatkul, function ($query) {
                $query->where('id_mata_kuliah', $this->selectedMatkul);
            })
            ->when($this->selectedKelas, function ($query) {
                $query->where('id_kelas', $this->selectedKelas);
            })
            ->when($this->selectedSemester, function ($query) {
                $query->where('id_semester', $this->selectedSemester);
            })
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->WhereHas('kelas', function ($q) {
                          $q->where('nama_kelas', 'like', '%' . $this->search . '%');
                      })
                      ->orWhereHas('mataKuliah', function ($q) {
                          $q->where('nama_mata_kuliah', 'like', '%' . $this->search . '%');
                      });
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.admin.presensi-dosen.detail', [
            'beritaAcaras' => $beritaAcaras,
            'semesters' => $this->semesters,
            'kelasList' => $this->kelasList,
            'matkuls' => $this->matkuls,
        ]);
    }
}
