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
        $krs = KRS::all();
        $kelasByProdi = Kelas::with('matkul')->get()->groupBy('kode_prodi'); // Kelompokkan kelas berdasarkan kode_prodi

        $ruanganList = Ruangan::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = [
            ['sesi' => 1, 'jam_mulai' => '08:00', 'jam_selesai' => '10:00'],
            ['sesi' => 2, 'jam_mulai' => '10:15', 'jam_selesai' => '12:15'],
            ['sesi' => 3, 'jam_mulai' => '13:00', 'jam_selesai' => '15:00'],
        ];

        foreach ($kelasByProdi as $prodi => $kelasList) {
            $classIndex = 0;
            $totalKelas = $kelasList->count();
            $classSessions = [];
            $dayIndex = 0;
            $slotIndex = 0;

            foreach ($kelasList as $kelas) {
                $classSessions[$kelas->id_kelas] = $kelas->matkul->sks_tatap_muka;
            }

            while ($classIndex < $totalKelas) {
                $day = $days[$dayIndex]; // Current day
                $timeSlot = $timeSlots[$slotIndex]; // Current time slot
                $kelas = $kelasList[$classIndex];
                $ruangan = null;
                $remainingSKS = $classSessions[$kelas->id_kelas];

                if ($remainingSKS <= 0) {
                    $classIndex++;
                    continue;
                }

                // Ambil jumlah mahasiswa terdaftar di KRS untuk kelas ini
                $jumlahMahasiswa = KRS::where('id_kelas', $kelas->id_kelas)->count();

                // Cari ruangan yang kapasitasnya mencukupi di hari yang berbeda
                $roomFound = false;
                $originalDayIndex = $dayIndex;

                // Loop through the days and try to find a suitable room
                while (!$roomFound) {
                    // Search for a room on the current day
                    foreach ($ruanganList as $room) {
                        if ($room->kapasitas >= $jumlahMahasiswa) {
                            $ruangan = $room;
                            $roomFound = true;
                            break; // Stop searching once a suitable room is found
                        }
                    }

                    // If no room is found, move to the next day
                    if (!$roomFound) {
                        $dayIndex++;
                        if ($dayIndex >= count($days)) {
                            $dayIndex = 0; // Reset to Monday if we reach the end of the week
                        }

                        // If we checked all days, break out of the loop
                        if ($dayIndex == $originalDayIndex) {
                            break;
                        }
                    }
                }

                // If no room is found after checking all days, skip to the next class
                if (!$ruangan) {
                    session()->flash('message', 'Kelas ' . $kelas->nama_kelas . ' tidak dapat dijadwalkan karena tidak ada ruangan yang sesuai.');
                    $classIndex++;
                    continue;
                }


                // Cek apakah kelas sudah memiliki 2 sesi pada hari yang sama
                $dailySesiCount = Jadwal::where('id_kelas', $kelas->id_kelas)
                    ->where('hari', $days[$dayIndex])
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

                // Cek untuk konflik jadwal di prodi yang sama
                $conflict = Jadwal::where('hari', $days[$dayIndex])
                    ->where('id_ruangan', $ruangan->id_ruangan) // Periksa ruangan
                    ->where(function ($query) use ($timeSlot) {
                        $query->whereBetween('jam_mulai', [$timeSlot['jam_mulai'], $timeSlot['jam_selesai']])
                            ->orWhereBetween('jam_selesai', [$timeSlot['jam_mulai'], $timeSlot['jam_selesai']])
                            ->orWhere(function ($query) use ($timeSlot) {
                                $query->where('jam_mulai', '<=', $timeSlot['jam_mulai'])
                                    ->where('jam_selesai', '>=', $timeSlot['jam_selesai']);
                            });
                    })->exists();


                if (!$conflict) {
                    // Tambahkan jadwal
                    Jadwal::create([
                        'id_kelas' => $kelas->id_kelas,
                        'kode_prodi' => $prodi,
                        'hari' => $days[$dayIndex],
                        'tanggal' => Carbon::now()->next($days[$dayIndex])->toDateString(),
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

                // Pindah ke sesi berikutnya
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