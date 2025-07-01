<?php

namespace App\Livewire\Admin\Emonev;

use App\Models\MahasiswaEmonev;
use App\Models\PeriodeEMonev;
use App\Models\Prodi;
use App\Models\KRS;
use App\Models\Mahasiswa;
use App\Models\Semester;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


class ListMahasiswa extends Component
{
    public $selectedSemester = '';
    public $periodes = [];
    public $itung;
    public $itung2;
    public $itung3;
    public $nama;
    public $semester;
    public $status = null;
    public $mahasiswaList = [];
    public $mahasiswaSudahIsi = [];
    public $mahasiswaBelumIsi = [];

    public function mount()
    {
        $this->loadData();
    }

    public function updatedStatus()
    {
        $this->loadData();
    }

    public function loadData()
    {
        if (empty($this->selectedSemester)) {
            $periodes = PeriodeEMonev::all();
            $aktif = false;

            foreach ($periodes as $periode) {
                if ($periode->isAktif()) {
                    $this->selectedSemester = $periode->id_periode;
                    $aktif = true;
                }
            }

            if (!$aktif) {
                if ($this->periodes->isEmpty()) {
                    return $this->dispatch('warning', [
                        'message' => 'Tidak ada periode yang tersedia.',
                    ]);
                } else {
                    // If no active period is found, set to the latest period
                    $this->selectedSemester = PeriodeEMonev::latest()->first()->id_periode;
                }
            }
        }

        $periode = PeriodeEMonev::with('semester')
            ->where('id_periode', $this->selectedSemester)
            ->first();

        $sesi = substr($periode->nama_periode, 6, 1);

        $mahasiswaList = Mahasiswa::whereIn('NIM', function ($query) use ($periode) {
            $query->select('NIM')
                ->from('krs')
                ->where('id_semester', $periode->id_semester);
        })->get();

        $mahasiswaBelumIsi = [];
        $mahasiswaSudahIsi = [];

        foreach ($mahasiswaList as $mhs) {
            $matkulKRS = KRS::where('NIM', $mhs->NIM)
                ->where('id_semester', $periode->id_semester)
                ->pluck('id_mata_kuliah');

            $matkulEmonev = MahasiswaEmonev::where('NIM', $mhs->NIM)
                ->where('id_semester', $periode->id_semester)
                ->where('sesi', $sesi)
                ->pluck('id_mata_kuliah');

            $sudahIsiSemua = $matkulKRS->diff($matkulEmonev)->isEmpty();

            if (!$sudahIsiSemua) {
                $mahasiswaBelumIsi[] = $mhs;
            } else {
                $mahasiswaSudahIsi[] = $mhs;
            }
        }

        $this->nama = $periode->nama_periode;
        $this->itung2 = count($mahasiswaList);         // Total mahasiswa yang punya KRs
        $this->itung = count($mahasiswaSudahIsi);       // Mahasiswa yang sudah isi semua e-Monev
        $this->itung3 = count($mahasiswaBelumIsi);

        $this->mahasiswaBelumIsi = $mahasiswaBelumIsi;
        $this->mahasiswaSudahIsi = $mahasiswaSudahIsi;

    }

    public function render()
    {
        return view('livewire.admin.emonev.list-mahasiswa', [
            'periode' => PeriodeEMonev::all(),
            'nama' => $this->nama,
            'mahasiswa' => $this->itung2,
            'emonev' => $this->itung,
            'belum' => $this->itung3,
            'mahasiswabelum' => $this->mahasiswaBelumIsi,
            'mahasiswasudah' => $this->mahasiswaSudahIsi,
        ]);
    }
}
