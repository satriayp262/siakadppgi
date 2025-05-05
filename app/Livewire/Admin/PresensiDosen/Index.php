<?php

namespace App\Livewire\Admin\PresensiDosen;

use Livewire\Component;
use App\Models\Dosen;
use App\Models\Semester;
use Livewire\WithPagination;
use App\Models\Prodi;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PresensiDosenExport;

class Index extends Component
{
    use WithPagination;

    public $month, $year, $search = '', $id_semester = "semua", $id_prodi = "semua";
    public $selectedProdi;
    public $selectedKodeProdi = '';

    public function mount()
    {
        $this->month = now()->month;
        $this->year = now()->year;
        $this->setDefaults();  // Mengatur nilai default
    }

    public function updatedMonth()
    {
        $this->resetPage();
    }

    public function updatedYear()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage(); // Reset page when search is updated
    }

    public function setDefaults()
    {
        // Set id_semester and id_prodi to null if "semua" is selected
        $this->id_semester = ($this->id_semester === "semua") ? null : $this->id_semester;
        $this->id_prodi = ($this->id_prodi === "semua") ? null : $this->id_prodi;
    }

    public function exportExcel()
    {
        // Menyiapkan nama file dengan kondisi semester dan prodi
        $this->setDefaults();  // Memastikan id_semester dan id_prodi sudah diset

        $nama_semester = $this->id_semester ? Semester::where('id_semester', $this->id_semester)->first()->nama_semester : null;
        $nama_prodi = $this->id_prodi ? Prodi::where('id_prodi', $this->id_prodi)->first()->nama_prodi : null;

        // Menentukan nama file berdasarkan semester dan prodi
        $fileName = 'Data Presensi Dosen ';
        if ($nama_semester) {
            $fileName .= $nama_semester . ' ';
        }
        if ($nama_prodi) {
            $fileName .= $nama_prodi . ' ';
        }
        $fileName .= now()->format('Y-m-d') . '.xlsx';

        // Menjalankan ekspor data
        return Excel::download(new PresensiDosenExport($this->month, $this->year, $this->search, $this->id_prodi, $this->id_semester), $fileName);
    }

    public function render()
    {
        $dosensQuery = Dosen::query();

        if ($this->selectedKodeProdi) {
            $dosensQuery->where('kode_prodi', $this->selectedKodeProdi);
        }

        // Search functionality (if implemented)
        if ($this->search) {
            $dosensQuery->where(function ($query) {
                $query->where('nama_dosen', 'like', '%' . $this->search . '%')
                    ->orWhere('nidn', 'like', '%' . $this->search . '%');
            });
        }

        // Ambil data semester dan prodi untuk dropdown
        $semester = Semester::all();
        $prodi = Prodi::all();

        // Ambil data dosen dan paginate
        $dosens = $dosensQuery->latest()->paginate(10);

        return view('livewire.admin.presensi-dosen.index', [
            'dosens' => $dosens,
            'semester' => $semester,
            'prodi' => $prodi
        ]);
    }
}
