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

    public $id_semester = 'semua';
    public $id_kelas = 'semua';
    public $id_mata_kuliah = 'semua';

    public function mount()
    {
        $this->semesters = Semester::orderBy('nama_semester')->get();
        $this->kelasList = Kelas::orderBy('nama_kelas')->get();
        $this->matkuls = Matakuliah::orderBy('nama_mata_kuliah')->get();
    }

    public function exportExcel()
    {
        // Debug: Cek nilai filter sebelum export
        logger()->info('Export Params:', [
            'nidn' => $this->nidn,
            'semester' => $this->id_semester,
            'kelas' => $this->id_kelas,
            'matkul' => $this->id_mata_kuliah
        ]);

        // Dapatkan nama-nama untuk filename
        $dosenName = BeritaAcara::with('dosen')
            ->where('nidn', $this->nidn)
            ->first()
            ->dosen->nama_dosen ?? 'Dosen';

        $semesterName = $this->id_semester !== 'semua'
            ? $this->semesters->firstWhere('id_semester', $this->id_semester)->nama_semester
            : 'Semua Semester';

        $kelasName = $this->id_kelas !== 'semua'
            ? $this->kelasList->firstWhere('id_kelas', $this->id_kelas)->nama_kelas
            : 'Semua Kelas';

        $matkulName = $this->id_mata_kuliah !== 'semua'
            ? $this->matkuls->firstWhere('id_mata_kuliah', $this->id_mata_kuliah)->nama_mata_kuliah
            : 'Semua Matkul';

        // Generate filename
        $filename = 'Berita Acara ' . $dosenName . ' - ' . $kelasName . ' - ' . $matkulName . ' - ' . $semesterName . '.xlsx';
        $filename = preg_replace('/[^A-Za-z0-9 \-\.]/', '', $filename);
        $filename = preg_replace('/\s+/', ' ', $filename);

        // Cek data sebelum export
        $query = BeritaAcara::with(['kelas', 'mataKuliah', 'dosen', 'semester'])
            ->where('nidn', $this->nidn);

        if ($this->id_semester !== 'semua') {
            $query->where('id_semester', $this->id_semester);
        }

        if ($this->id_kelas !== 'semua') {
            $query->where('id_kelas', $this->id_kelas);
        }

        if ($this->id_mata_kuliah !== 'semua') {
            $query->where('id_mata_kuliah', $this->id_mata_kuliah);
        }

        $count = $query->count();
        logger()->info('Data count before export: ' . $count);

        return Excel::download(new BeritaAcaraExport(
            $this->nidn,
            $this->id_semester !== 'semua' ? $this->id_semester : null,
            $this->id_kelas !== 'semua' ? $this->id_kelas : null,
            $this->id_mata_kuliah !== 'semua' ? $this->id_mata_kuliah : null
        ), $filename);
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $beritaAcaras = BeritaAcara::with(['kelas', 'mataKuliah', 'dosen'])
            ->where('nidn', $this->nidn)
            ->when($this->selectedMatkul, fn($query) =>
            $query->where('id_mata_kuliah', $this->selectedMatkul))
            ->when($this->selectedKelas, fn($query) =>
            $query->where('id_kelas', $this->selectedKelas))
            ->when($this->selectedSemester, fn($query) =>
            $query->where('id_semester', $this->selectedSemester))
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereHas('kelas', fn($q) =>
                    $q->where('nama_kelas', 'like', '%' . $this->search . '%'))
                        ->orWhereHas('mataKuliah', fn($q) =>
                        $q->where('nama_mata_kuliah', 'like', '%' . $this->search . '%'));
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
