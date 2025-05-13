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
use Livewire\Attributes\On;

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

    public function setDefaults()
    {
        // Pastikan id_semester dan kode_prodi sudah diset
        if (!$this->semester) {
            $this->semester = 'semua';  // Atau ID semester default jika tidak ada yang dipilih
        }

        if (!$this->selectedProdi) {
            $this->selectedProdi = 'semua';  // Atau kode prodi default jika tidak ada yang dipilih
        }
    }


    public function exportExcel()
    {
        // Menyiapkan nama file dengan kondisi semester dan prodi
        $this->setDefaults();  // Memastikan id_semester dan id_prodi sudah diset

        // Mendapatkan nama semester dan prodi berdasarkan ID
        $semesterData = $this->semester ? Semester::where('id_semester', $this->semester)->first() : null;
        $nama_semester = $semesterData ? $semesterData->nama_semester : 'Semua Semester';

        // Mengecek apakah kode_prodi ada dan valid
        $prodiData = $this->selectedProdi ? Prodi::where('kode_prodi', $this->selectedProdi)->first() : null;
        $nama_prodi = $prodiData ? $prodiData->nama_prodi : 'Semua Prodi';

        // Menentukan nama file berdasarkan semester dan prodi
        $fileName = 'Data Presensi Mahasiswa ';
        $fileName .= $nama_semester . ' ';
        $fileName .= $nama_prodi . ' ';
        $fileName .= now()->format('Y-m-d') . '.xlsx';

        // Menjalankan ekspor data dengan filter berdasarkan semester dan prodi
        return Excel::download(new MahasiswaPresensiExport($this->semester, $this->selectedProdi), $fileName);
    }

    #[On('kirimEmail')]
    public function kirimEmailHandler($nim)
    {
        $this->kirimEmail($nim);
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

        if ($mahasiswa && $mahasiswa->alpha_count >= 2 && $mahasiswa->user) {
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
            $this->dispatch('pg:eventRefresh-presensi-mahasiwa-table-qyqn0i-table');
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
        $dataMahasiswa = Mahasiswa::with(['presensi' => function ($query) {
            $query->select('nim', 'keterangan', 'created_at');
        }])
            ->withCount([
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
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('NIM', 'like', '%' . $this->search . '%')
                    ->orWhereHas('prodi', function ($prodiQuery) {
                        $prodiQuery->where('nama_prodi', 'like', '%' . $this->search . '%');
                    });
            })
            ->when($this->selectedProdi, function ($query) {
                $query->where('kode_prodi', $this->selectedProdi);
            })
            ->paginate(10);

        // Rename variables here to avoid conflict
        $semesterList = Semester::all();
        $prodiList = Prodi::all();

        return view('livewire.admin.presensi-mahasiswa.index', [
            'dataMahasiswa' => $dataMahasiswa,
            'semesterList' => $semesterList,  // Changed from 'semester'
            'prodiList' => $prodiList       // Changed from 'prodi'
        ]);
    }
}
