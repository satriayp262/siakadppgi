<?php

namespace App\Livewire\Admin\Jadwal;

use Livewire\Component;
use App\Models\Kelas;
use App\Models\Ruangan;
use App\Models\Jadwal;
use App\Models\Prodi;
use App\Models\KRS;
use Carbon\Carbon;

class Index extends Component
{
    public $id_kelas;
    public $hari;
    public $jam_mulai;
    public $jam_selesai;
    public $sesi;
    public $id_ruangan;
    public $prodi;

    public function generate()
    {
        $krs = krs::all();
        $kelasByProdi = Kelas::with('matkul')
            ->get()
            ->groupBy('kode_prodi'); // Kelompokkan kelas berdasarkan kode_prodi

        $ruanganList = Ruangan::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = [
            ['sesi' => 1, 'jam_mulai' => '08:00', 'jam_selesai' => '10:00'],
            ['sesi' => 2, 'jam_mulai' => '10:15', 'jam_selesai' => '12:15'],
            ['sesi' => 3, 'jam_mulai' => '13:00', 'jam_selesai' => '15:00'],
        ];

        foreach ($kelasByProdi as $prodi => $kelasList) {
            // Initialize variables for the current prodi
            $kelasList = $kelasList->shuffle();
            $classIndex = 0;
            $totalKelas = $kelasList->count();
            $classSessions = [];
            $dayIndex = 0;
            $slotIndex = 0;

            // Initialize SKS for each class
            foreach ($kelasList as $kelas) {
                $classSessions[$kelas->id_kelas] = $kelas->matkul->sks_tatap_muka;
            }

            while ($classIndex < $totalKelas) {
                $day = $days[$dayIndex]; // Current day
                $timeSlot = $timeSlots[$slotIndex]; // Current time slot
                $kelas = $kelasList[$classIndex];
                $ruangan = $ruanganList[$slotIndex % $ruanganList->count()];
                $remainingSKS = $classSessions[$kelas->id_kelas];

                if ($remainingSKS <= 0) {
                    $classIndex++;
                    continue;
                }

                // Check if the class already has 2 sessions on the same day
                $dailySesiCount = Jadwal::where('id_kelas', $kelas->id_kelas)
                    ->where('hari', $day)
                    ->count();
                if ($dailySesiCount >= 2) {
                    $slotIndex++;
                    if ($slotIndex >= count($timeSlots)) {
                        $slotIndex = 0;
                        $dayIndex++;
                        if ($dayIndex >= count($days)) {
                            $dayIndex = 0;
                        }
                    }
                    continue;
                }

                // Check for conflicts within the same prodi
                $conflict = Jadwal::where('hari', $day)
                    ->where('kode_prodi', $prodi) // Restrict conflict check to the same prodi
                    ->where(function ($query) use ($timeSlot, $ruangan) {
                        $query->where('id_ruangan', $ruangan->id_ruangan)
                            ->where(function ($query) use ($timeSlot) {
                                $query->whereBetween('jam_mulai', [$timeSlot['jam_mulai'], $timeSlot['jam_selesai']])
                                    ->orWhereBetween('jam_selesai', [$timeSlot['jam_mulai'], $timeSlot['jam_selesai']])
                                    ->orWhere(function ($query) use ($timeSlot) {
                                        $query->where('jam_mulai', '<=', $timeSlot['jam_mulai'])
                                            ->where('jam_selesai', '>=', $timeSlot['jam_selesai']);
                                    });
                            });
                    })->exists();

                if (!$conflict) {
                    // Add the schedule
                    Jadwal::create([
                        'id_kelas' => $kelas->id_kelas,
                        'kode_prodi' => $prodi,
                        'hari' => $day,
                        'tanggal' => Carbon::now()->next($day)->toDateString(),
                        'jam_mulai' => $timeSlot['jam_mulai'],
                        'jam_selesai' => $timeSlot['jam_selesai'],
                        'sesi' => $timeSlot['sesi'],
                        'id_ruangan' => $ruangan->id_ruangan,
                    ]);

                    $classSessions[$kelas->id_kelas] -= 1;

                    if ($classSessions[$kelas->id_kelas] <= 0) {
                        $classIndex++;
                    }
                }

                // Move to the next time slot
                $slotIndex++;
                if ($slotIndex >= count($timeSlots)) {
                    $slotIndex = 0;
                    $dayIndex++;
                    if ($dayIndex >= count($days)) {
                        $dayIndex = 0;
                    }
                }
            }
        }

        $this->dispatch('created', ['message' => 'Jadwal Created Successfully']);
    }




    public function destroy()
    {
        Jadwal::truncate();
        $this->dispatch('destroyed', ['message' => 'Jadwal Deleted Successfully']);
    }

    public function render()
    {
        $jadwals = Jadwal::orderByRaw("
            FIELD(hari, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday')
        ")->get();

        $prodis = Prodi::all();

        if ($this->prodi) {
            $jadwals = $jadwals->where('kode_prodi', $this->prodi);
        }

        return view('livewire.admin.jadwal.index', [
            'jadwals' => $jadwals,
            'prodis' => $prodis,
        ]);
    }
}