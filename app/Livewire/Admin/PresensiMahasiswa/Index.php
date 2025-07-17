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
use App\Models\Matakuliah;
use App\Models\Kelas;

class Index extends Component
{
    use WithPagination;

    public $semester = 'semua';
    public $semesters = [];
    public $selectedProdi = 'semua';
    public $prodi = [];
    public $spSent = false;
    public $search = '';
    public $id_mata_kuliah = 'semua';
    public $id_kelas = 'semua';
    public $filteredMatkulList = [];
    public $filteredKelasList = [];

    public function mount()
    {
        $this->prodi = Prodi::all();
        $this->semesters = Semester::all();
        $this->updateMatkulKelasOptions();
    }

    public function updatedSemester()
    {
        $this->updateMatkulKelasOptions();
    }

    public function updatedSelectedProdi()
    {
        $this->updateMatkulKelasOptions();
    }

    public function updateMatkulKelasOptions()
    {
        // Update filtered mata kuliah list
        $matkulQuery = Matakuliah::query();
        if ($this->selectedProdi !== 'semua') {
            $matkulQuery->where('kode_prodi', $this->selectedProdi);
        }
        if ($this->semester !== 'semua') {
            $matkulQuery->whereHas('semester', function ($q) {
                $q->where('id_semester', $this->semester);
            });
        }
        $this->filteredMatkulList = $matkulQuery->get()->all(); // Add ->all() to make it explicit this is an array

        // Update filtered kelas list
        $kelasQuery = Kelas::query();
        if ($this->selectedProdi !== 'semua') {
            $kelasQuery->where('kode_prodi', $this->selectedProdi);
        }
        if ($this->semester !== 'semua') {
            $kelasQuery->where('id_semester', $this->semester);
        }
        $this->filteredKelasList = $kelasQuery->get()->all(); // Add ->all() to make it explicit this is an array

        // Reset mata kuliah and kelas selections if they're no longer valid
        if ($this->id_mata_kuliah !== 'semua' && !collect($this->filteredMatkulList)->contains('id_mata_kuliah', $this->id_mata_kuliah)) {
            $this->id_mata_kuliah = 'semua';
        }
        if ($this->id_kelas !== 'semua' && !collect($this->filteredKelasList)->contains('id_kelas', $this->id_kelas)) {
            $this->id_kelas = 'semua';
        }
    }

    public function setDefaults()
    {
        if (!$this->semester) {
            $this->semester = 'semua';
        }

        if (!$this->selectedProdi) {
            $this->selectedProdi = 'semua';
        }

        if (!$this->id_mata_kuliah) {
            $this->id_mata_kuliah = 'semua';
        }

        if (!$this->id_kelas) {
            $this->id_kelas = 'semua';
        }
    }

    public function exportExcel()
    {
        $this->setDefaults();

        $semesterData = $this->semester !== 'semua' ? Semester::find($this->semester) : null;
        $nama_semester = $semesterData ? str_replace(['/', '\\'], '-', $semesterData->nama_semester) : 'Semua Semester';

        $prodiData = $this->selectedProdi !== 'semua' ? Prodi::find($this->selectedProdi) : null;
        $nama_prodi = $prodiData ? str_replace(['/', '\\'], '-', $prodiData->nama_prodi) : 'Semua Prodi';

        $matkulData = $this->id_mata_kuliah !== 'semua' ? Matakuliah::find($this->id_mata_kuliah) : null;
        $nama_matkul = $matkulData ? str_replace(['/', '\\'], '-', $matkulData->nama_mata_kuliah) : 'Semua Mata Kuliah';

        $kelasData = $this->id_kelas !== 'semua' ? Kelas::find($this->id_kelas) : null;
        $nama_kelas = $kelasData ? str_replace(['/', '\\'], '-', $kelasData->nama_kelas) : 'Semua Kelas';

        // Create a clean filename without special characters
        $fileName = 'Data Presensi Mahasiswa ' . $nama_semester . ' ' . $nama_prodi . ' ' .
            $nama_matkul . ' ' . $nama_kelas . ' ' . now()->format('Y-m-d') . '.xlsx';

        // Remove any remaining special characters that might cause issues
        $fileName = preg_replace('/[\/\\\\:*?"<>|]/', '-', $fileName);

        return Excel::download(
            new MahasiswaPresensiExport(
                $this->semester,
                $this->selectedProdi,
                $this->id_mata_kuliah,
                $this->id_kelas
            ),
            $fileName
        );
    }

    #[On('kirimEmail')]
    public function kirimEmailHandler($nim)
    {
        $this->kirimEmail($nim, $this->id_mahasiswa);
    }

    public function kirimEmail($nim, $id_mahasiswa)
    {
        $sudahKirim = RiwayatSP::where('nim', $nim)->exists();

        if ($sudahKirim) {
            $this->dispatch('spSentError', message: 'Surat peringatan sudah pernah dikirim.');
            return;
        }

        $mahasiswa = Mahasiswa::where('id_mahasiswa', $id_mahasiswa)
            ->withCount(['presensi as alpha_count' => function ($query) {
                $query->where('keterangan', 'Alpha')
                    ->when($this->semester !== 'semua', function ($q) {
                        $q->where('id_semester', $this->semester);
                    })
                    ->when($this->id_mata_kuliah !== 'semua', function ($q) {
                        $q->where('id_mata_kuliah', $this->id_mata_kuliah);
                    })
                    ->when($this->id_kelas !== 'semua', function ($q) {
                        $q->where('id_kelas', $this->id_kelas);
                    });
            }])
            ->first();

        if ($mahasiswa && $mahasiswa->alpha_count >= 2 && $mahasiswa->user) {
            $countSP = RiwayatSP::count() + 1;
            $no_surat = sprintf("%03d", $countSP) . "/PPGI/11.7/" . date('m') . "/" . date('Y');

            $data = [
                'nama' => $mahasiswa->nama,
                'nim' => $mahasiswa->NIM,
                'alpha_count' => $mahasiswa->alpha_count,
                'no_surat' => $no_surat,
            ];

            Mail::to($mahasiswa->user->email)->send(new PeringatanMail($data));

            RiwayatSP::create([
                'nim' => $nim,
                'sent_at' => now(),
            ]);

            $this->spSent = true;
            $this->dispatch('pg:eventRefresh-presensi-mahasiwa-table-qyqn0i-table');
            $this->dispatch('spSentSuccess', nim: $nim);
        } else {
            $this->dispatch('spSentError', message: 'Mahasiswa tidak ditemukan atau belum memenuhi batas Alpha.');
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        return view('livewire.admin.presensi-mahasiswa.index', [
            'semesterList' => $this->semesters,
            'prodiList' => $this->prodi,
            'matkulList' => $this->filteredMatkulList,
            'kelasList' => $this->filteredKelasList,
        ]);
    }
}
