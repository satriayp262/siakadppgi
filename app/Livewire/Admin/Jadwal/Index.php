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
            $slotIndex = 0;
            $dayIndex = 0;
            $dayRuangan = 0;

            foreach ($kelasList as $kelas) {
                $classSessions[$kelas->id_kelas] = $kelas->matkul->sks_tatap_muka;
            }

            while ($classIndex < $totalKelas) {
                $day = $days[$dayIndex]; // Hari untuk jadwal
                $kelas = $kelasList[$classIndex];
                $remainingSKS = $classSessions[$kelas->id_kelas];

                if ($remainingSKS <= 0) {
                    $classIndex++;
                    continue; // Pindah ke kelas berikutnya jika SKS habis
                }

                // Cari time slot yang sesuai
                $timeSlot = $timeSlots[$slotIndex];

                // Ambil jumlah mahasiswa
                $jumlahMahasiswa = KRS::where('id_kelas', $kelas->id_kelas)->count();

                // Cari ruangan yang sesuai
                $ruangan = null;
                $roomFound = false;

                while (!$roomFound) {
                    $currentDay = $days[$dayRuangan]; // Hari untuk ruangan
                    foreach ($ruanganList as $room) {
                        // Cek apakah ruangan tersedia di hari dan sesi tertentu
                        $isRoomAvailable = !Jadwal::where('hari', $currentDay)
                            ->where('id_ruangan', $room->id_ruangan)
                            ->where(function ($query) use ($timeSlot) {
                                $query->whereBetween('jam_mulai', [$timeSlot['jam_mulai'], $timeSlot['jam_selesai']])
                                    ->orWhereBetween('jam_selesai', [$timeSlot['jam_mulai'], $timeSlot['jam_selesai']])
                                    ->orWhere(function ($query) use ($timeSlot) {
                                        $query->where('jam_mulai', '<=', $timeSlot['jam_mulai'])
                                            ->where('jam_selesai', '>=', $timeSlot['jam_selesai']);
                                    });
                            })->exists();

                        if ($room->kapasitas >= $jumlahMahasiswa && $isRoomAvailable) {
                            $ruangan = $room;
                            $roomFound = true;
                            break;
                        }
                    }

                    // Jika ruangan tidak ditemukan, pindah ke hari berikutnya untuk ruangan
                    if (!$roomFound) {
                        $dayRuangan++;
                        if ($dayRuangan >= count($days)) {
                            $dayRuangan = 0; // Reset ke hari pertama untuk ruangan
                        }

                        // Jika kembali ke hari awal, berarti semua hari sudah diperiksa
                        if ($dayRuangan == $dayIndex) {
                            break; // Tidak ada ruangan yang cocok
                        }
                    }
                }

                // Jika tidak ada ruangan yang cocok, pindah ke kelas berikutnya
                if (!$roomFound) {
                    session()->flash('message', "Kelas {$kelas->nama_kelas} tidak dapat dijadwalkan karena tidak ada ruangan yang sesuai.");
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

                // Tambahkan jadwal jika tidak ada konflik
                $conflict = Jadwal::where('hari', $day)
                    ->where('kode_prodi', $prodi)
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
                    // Tambahkan jadwal
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

                    // Kurangi jumlah SKS
                    $classSessions[$kelas->id_kelas] -= 1;

                    // Jika SKS habis, pindah ke kelas berikutnya
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