<?php

namespace App\Livewire\Admin\PresensiMahasiswa;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Exports\MahasiswaPresensiExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Prodi;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Mail;
use App\Mail\PeringatanMail;
use App\Models\Semester;

class Index extends Component
{
    use WithPagination;

    public $semester; // Untuk menyimpan semester terpilih
    public $semesters = []; // Untuk list semua semester    public $selectedProdi;
    public $prodi;
    public $selectedProdi;

    public $user;
    public $search = '';

    public function mount()
    {
        $this->prodi = Prodi::all();
        $this->semesters = Semester::all(); // Ambil semua semester sebagai koleksi
    }

    public function getAllSemesters()
    {
        return Semester::pluck('nama_semester', 'id_semester');
    }

    public function exportExcel()
    {
        // Ambil filter semester yang dipilih
        $semester = $this->semester ?? 'Default'; // Default jika semester belum dipilih
        $selectedProdi = $this->selectedProdi; // Ambil filter program studi

        // Nama file berdasarkan filter semester
        $fileName = "Presensi_Mahasiswa_Semester_{$semester}.xlsx";

        // Ekspor menggunakan export class dengan filter semester yang dipilih
        return Excel::download(new MahasiswaPresensiExport($semester, $selectedProdi), $fileName);
    }

    public function kirimEmail($nim)
    {
        $mahasiswa = Mahasiswa::where('NIM', $nim)
            ->withCount(['presensi as alpha_count' => function ($query) {
                $query->where('keterangan', 'Alpha');
            }])
            ->first();

        if ($mahasiswa && $mahasiswa->alpha_count == 2 && $mahasiswa->user) {
            $data = [
                'nama' => $mahasiswa->nama, // Pastikan nama terisi
                'nim' => $mahasiswa->NIM,
                'alpha_count' => $mahasiswa->alpha_count,
            ];

            // Kirim email
            Mail::to($mahasiswa->user->email)->send(new PeringatanMail($data));

            session()->flash('success', 'Surat peringatan berhasil dikirim.');
        } else {
            session()->flash('error', 'Mahasiswa tidak ditemukan atau belum memenuhi batas Alpha.');
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
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
            'presensi as alpha_count' => function ($query) {
                $query->where('keterangan', 'Alpha');
            },
            'presensi as ijin_count' => function ($query) {
                $query->where('keterangan', 'Ijin');
            },
            'presensi as sakit_count' => function ($query) {
                $query->where('keterangan', 'Sakit');
            },
        ])
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            ->when($this->semester, function ($query) {
                $query->whereHas('presensi', function ($presensiQuery) {
                    $presensiQuery->whereHas('token', function ($tokenQuery) {
                        $tokenQuery->where('id_semester', intval($this->semester)); // Pastikan integer
                    });
                });
            })
            ->when($this->selectedProdi, function ($query) {
                $query->where('kode_prodi', $this->selectedProdi);
            })
            ->paginate(10);

        return view('livewire.admin.presensi-mahasiswa.index', [
            'dataMahasiswa' => $dataMahasiswa,
            'semester' => $this->getAllSemesters(), // Kirim data semester ke view
        ]);
    }
}
