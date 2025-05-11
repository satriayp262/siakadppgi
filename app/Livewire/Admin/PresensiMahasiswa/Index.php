<?php

namespace App\Livewire\Admin\PresensiMahasiswa;

use App\Models\Mahasiswa;
use App\Models\RiwayatSP;
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
    public $semesters = []; // Untuk list semua semester
    public $selectedProdi;
    public $prodi;
    public $spSent = false;
    public $search = '';

    public function mount()
    {
        // Load all Prodi and Semester data for dropdowns and filters
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
        $sudahKirim = RiwayatSP::where('nim', $nim)->exists();

        if ($sudahKirim) {
            session()->flash('error', 'Surat peringatan sudah pernah dikirim.');
            return;
        }

        $mahasiswa = Mahasiswa::where('NIM', $nim)
            ->withCount(['presensi as alpha_count' => function ($query) {
                $query->where('keterangan', 'Alpha');
            }])
            ->first();

        if ($mahasiswa && $mahasiswa->alpha_count == 2 && $mahasiswa->user) {
            // Generate nomor surat otomatis
            $countSP = RiwayatSP::count() + 1; // Hitung jumlah surat sebelumnya
            $no_surat = sprintf("%03d", $countSP) . "/PPGI/11.7/" . date('m') . "/" . date('Y');

            $data = [
                'nama' => $mahasiswa->nama,
                'nim' => $mahasiswa->NIM,
                'alpha_count' => $mahasiswa->alpha_count,
                'no_surat' => $no_surat, // Sertakan nomor surat
            ];

            // Kirim email dengan nomor surat
            Mail::to($mahasiswa->user->email)->send(new PeringatanMail($data));

            // Simpan riwayat pengiriman SP dengan nomor surat
            RiwayatSP::create([
                'nim' => $nim,
                'sent_at' => now(),
            ]);

            session()->flash('success', 'Surat peringatan berhasil dikirim dengan nomor surat.');
            $this->spSent = true;

            // Emit event ke front-end untuk disable tombol
            $this->dispatch('spSentSuccess', nim: $nim);
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
        // Ambil semua data mahasiswa
        $dataMahasiswa = Mahasiswa::with(['presensi' => function ($query) {
            $query->select('nim', 'keterangan', 'created_at');
        }])
            ->withCount([
                'presensi as hadir_count' => function ($query) {
                    $query->where('keterangan', 'Hadir');
                    if ($this->semester) {
                        $query->whereHas('token', function ($tokenQuery) {
                            $tokenQuery->where('id_semester', intval($this->semester));
                        });
                    }
                },
                'presensi as alpha_count' => function ($query) {
                    $query->where('keterangan', 'Alpha');
                    if ($this->semester) {
                        $query->whereHas('token', function ($tokenQuery) {
                            $tokenQuery->where('id_semester', intval($this->semester));
                        });
                    }
                },
                'presensi as ijin_count' => function ($query) {
                    $query->where('keterangan', 'Ijin');
                    if ($this->semester) {
                        $query->whereHas('token', function ($tokenQuery) {
                            $tokenQuery->where('id_semester', intval($this->semester));
                        });
                    }
                },
                'presensi as sakit_count' => function ($query) {
                    $query->where('keterangan', 'Sakit');
                    if ($this->semester) {
                        $query->whereHas('token', function ($tokenQuery) {
                            $tokenQuery->where('id_semester', intval($this->semester));
                        });
                    }
                },
            ])
            // Filter nama mahasiswa jika ada pencarian
            ->when($this->search, function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%');
            })
            // Filter program studi jika dipilih
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
