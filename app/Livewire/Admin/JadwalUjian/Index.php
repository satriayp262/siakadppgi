<?php

namespace App\Livewire\Admin\JadwalUjian;

use Livewire\Component;
use App\Models\Jadwal;
use App\Models\Prodi;
use App\Models\Semester;
use Carbon\Carbon;

class Index extends Component
{
    public $semesterfilter;
    public $prodi;
    

    public function tanggal()
    {
        $this->validate();
        // Ambil semua jadwal yang dikelompokkan berdasarkan 'kode_prodi'
        $jadwalUjians = Jadwal::orderBy('id_kelas')
            ->orderByRaw("FIELD(hari, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')")
            ->get()
            ->groupBy('id_kelas'); // Kelompokkan berdasarkan id_kelas
        // Iterasi melalui setiap grup jadwal berdasarkan 'kode_prodi'
        foreach ($jadwalUjians as $group) {

            // Ambil tanggal awal dari input
            $tanggal = Carbon::parse($this->ujian);

            // Inisialisasi hari sebelumnya untuk setiap grup
            $previousHari = 'Monday';

            // Iterasi untuk setiap jadwal dalam grup
            foreach ($group as $jadwal) {
                // Tentukan hari dan sesuaikan tanggal
                if ($jadwal->hari !== $previousHari) {
                    // Jika hari berubah, tambah 1 hari pada tanggal
                    $tanggal = $tanggal->addDay();
                }

                // Update tanggal untuk jadwal ini
                $jadwal->update([
                    'tanggal' => $tanggal->toDateString(), // Simpan tanggal dalam format yang sesuai
                    'jenis_ujian' => $this->jenis
                ]);

                // Simpan hari sebelumnya untuk perbandingan di iterasi berikutnya
                $previousHari = $jadwal->hari;
            }
        }
        $this->dispatch('updated', ['message' => 'Tanggal Ujian updated Successfully']);
    }

    public function render()
    {
        $jadwals = Jadwal::orderBy('id_kelas', direction: 'asc')
            ->orderByRaw("FIELD(hari, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')")
            ->orderBy(column: 'sesi', direction: 'asc')
            ->get();

        if ($this->semesterfilter) {
            $jadwals = $jadwals->where('id_semester', $this->semesterfilter);
        }

        $prodis = Prodi::all();

        if ($this->prodi) {
            $jadwals = $jadwals->where('kode_prodi', $this->prodi);
        }

        $semesters = Semester::orderBy('created_at', 'desc')->take(12)->get();
        $semesterfilters = Semester::orderBy('created_at', 'desc')->get();

        return view('livewire.admin.jadwal-ujian.index', [
            'jadwals' => $jadwals,
            'prodis' => $prodis,
            'semesters' => $semesters,
            'semesterfilters' => $semesterfilters
        ]);
    }
}
