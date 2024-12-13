<?php

namespace App\Livewire\Admin\PresensiMahasiswa;

use App\Models\Mahasiswa;
use App\Models\Presensi;
use App\Exports\MahasiswaPresensiExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Prodi;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    public $month;
    public $year;
    public $selectedProdi;
    public $prodi;

    public function mount()
    {
        $this->month = now()->format('m');
        $this->year = now()->format('Y');
        $this->prodi = Prodi::all();
    }

    public function exportExcel()
    {
        // Ambil filter bulan dan tahun yang dipilih
        $month = $this->month ?? now()->month; // Default ke bulan saat ini
        $year = $this->year ?? now()->year;   // Default ke tahun saat ini
        $selectedProdi = $this->selectedProdi; // Ambil filter program studi

        // Nama bulan dalam format teks
        $monthName = \Carbon\Carbon::createFromFormat('m', $month)->translatedFormat('F');

        // Nama file berdasarkan filter
        $fileName = "Presensi_Mahasiswa_{$monthName}_{$year}.xlsx";

        // Ekspor menggunakan export class dengan filter yang dipilih
        return Excel::download(new MahasiswaPresensiExport($month, $year, $selectedProdi), $fileName);
    }

    public function render()
    {
        $dataMahasiswa = Mahasiswa::with([
            'presensi' => function ($query) {
                $query->select('nim', 'keterangan', 'created_at');
            }
        ])->withCount([
            'presensi as hadir_count' => function ($query) {
                $query->where('keterangan', 'Hadir');
            },
            'presensi as ijin_count' => function ($query) {
                $query->where('keterangan', 'Ijin');
            },
            'presensi as sakit_count' => function ($query) {
                $query->where('keterangan', 'Sakit');
            },
        ])
            ->when($this->month, function ($query) {
                $query->whereHas('presensi', function ($presensiQuery) {
                    $presensiQuery->whereMonth('created_at', $this->month);
                }, '>=', 0); // Tetap termasuk mahasiswa tanpa presensi
            })
            ->when($this->year, function ($query) {
                $query->whereHas('presensi', function ($presensiQuery) {
                    $presensiQuery->whereYear('created_at', $this->year);
                }, '>=', 0); // Tetap termasuk mahasiswa tanpa presensi
            })
            ->when($this->selectedProdi, function ($query) {
                $query->where('kode_prodi', $this->selectedProdi);
            })
            ->paginate(10);

        return view('livewire.admin.presensi-mahasiswa.index', [
            'dataMahasiswa' => $dataMahasiswa,
        ]);
    }
}
