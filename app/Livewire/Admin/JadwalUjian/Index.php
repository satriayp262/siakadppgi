<?php

namespace App\Livewire\Admin\JadwalUjian;

use Livewire\Component;
use App\Models\Jadwal;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\ttd;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class Index extends Component
{
    public $semesterfilter;
    public $prodi;
    public $ujian;
    public $jenis;
    public $tanggalttd;

    public function rules()
    {
        return [
            'jenis' => 'required',
            'tanggalttd' => 'required',
            'ujian' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'jenis.required' => 'Jenis Ujian harus dipilih',
            'tanggalttd.required' => 'Tanggal TTD harus diisi',
            'ujian.required' => 'Tanggal Ujian harus diisi',
        ];
    }

    // public function clear2()
    // {
    //     jadwal::query()->update(['jenis_ujian', 'tanggal' => null]);

    //     $this->dispatch('destroyed', ['message' => 'jenis Ujian Deleted Successfully']);
    // }

    public function clear()
    {
        jadwal::query()->update(['jenis_ujian' => null, 'tanggal' => null]);
        ttd::query()->update(['tanggal_dibuat' => null]);

        $this->dispatch('destroyed', ['message' => 'Jadwal Ujian Deleted Successfully']);
    }

    public function tanggal()
    {
        $this->validate();

        $tanggalTTD = ttd::first();

        // Ambil data libur nasional dari API
        $response = Http::get('https://libur.deno.dev/api?year=' . Carbon::now()->year);
        $liburNasional = [];

        if ($response->ok()) {
            $liburNasional = collect($response->json())->pluck('date')->toArray(); // Format: Y-m-d
        }

        $jadwalUjians = Jadwal::orderBy('id_kelas')
            ->orderByRaw("FIELD(hari, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')")
            ->get()
            ->groupBy('id_kelas');

        foreach ($jadwalUjians as $group) {
            $tanggal = Carbon::parse($this->ujian);
            $previousHari = '';

            foreach ($group as $jadwal) {
                if ($jadwal->hari !== $previousHari) {
                    $tanggal = $tanggal->addDay();
                }

                // Lewati jika tanggal masuk tanggal merah atau akhir pekan
                while (in_array($tanggal->toDateString(), $liburNasional) || $tanggal->isWeekend()) {
                    $tanggal = $tanggal->addDay();
                }

                $jadwal->update([
                    'tanggal' => $tanggal->toDateString(),
                    'jenis_ujian' => $this->jenis
                ]);

                $previousHari = $jadwal->hari;
            }
        }

        if ($jadwalUjians->isEmpty()) {
            $this->dispatch('warning', ['message' => 'Belum Ada Jadwal']);
        } else {
            $tanggalTTD->update(['tanggal_dibuat' => $this->tanggalttd]);
            $this->dispatch('updated', ['message' => 'Jadwal Ujian Created Successfully']);
        }
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
