<?php

namespace App\Livewire\Admin\Jadwal;

use App\Models\Dosen;
use App\Models\Matakuliah;
use App\Models\Kelas;
use App\Models\Jadwal;
use Livewire\Component;

class Index extends Component
{
    public $message;

    // Fungsi untuk generate jadwal otomatis
    public function generateJadwal()
    {
        // Ambil data dosen, mata kuliah, dan kelas
        $dosenList = Dosen::all();
        $matkulList = Matakuliah::all();
        $kelasList = Kelas::all();

        // Tentukan hari dan jam ke-
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $timeSlots = [
            ['jam_ke' => 1, 'jam_mulai' => '08:00', 'jam_selesai' => '09:00'],
            ['jam_ke' => 2, 'jam_mulai' => '09:00', 'jam_selesai' => '10:00'],
            ['jam_ke' => 3, 'jam_mulai' => '10:00', 'jam_selesai' => '11:00'],
            ['jam_ke' => 4, 'jam_mulai' => '11:00', 'jam_selesai' => '12:00'],
            ['jam_ke' => 5, 'jam_mulai' => '13:00', 'jam_selesai' => '14:00'],
            ['jam_ke' => 6, 'jam_mulai' => '14:00', 'jam_selesai' => '15:00'],
            ['jam_ke' => 7, 'jam_mulai' => '15:00', 'jam_selesai' => '16:00'],
            ['jam_ke' => 8, 'jam_mulai' => '16:00', 'jam_selesai' => '17:00'],
        ];

        foreach ($dosenList as $dosen) {
            foreach ($matkulList as $matkul) {
                foreach ($kelasList as $kelas) {
                    foreach ($days as $day) {
                        foreach ($timeSlots as $slot) {
                            // Cek apakah dosen sudah punya jadwal di hari dan jam ini
                            $existingSchedule = Jadwal::where('nidn', $dosen->nidn)
                                ->where('hari', $day)
                                ->where('jam_ke', $slot['jam_ke'])
                                ->exists();

                            if ($existingSchedule) {
                                // Jika sudah ada jadwal dosen di hari dan jam ini, lewati iterasi
                                continue;
                            }

                            // Simpan jadwal ke database
                            Jadwal::create([
                                'nidn' => $dosen->nidn,
                                'kode_mata_kuliah' => $matkul->kode_mata_kuliah,
                                'kode_kelas' => $kelas->kode_kelas,
                                'hari' => $day,
                                'jam_ke' => $slot['jam_ke'],
                                'jam_mulai' => $slot['jam_mulai'],
                                'jam_selesai' => $slot['jam_selesai'],
                            ]);

                            // Untuk menghindari duplikasi pada dosen, matkul, atau kelas
                            // jika sudah ditambahkan, berhenti dari loop kelas, matkul, dosen.
                            break 4; // Keluar dari 4 loop (kelas, matkul, dosen, time)
                        }
                    }
                }
            }
        }

        $this->message = 'Jadwal berhasil di-generate!';
    }

    // Fungsi untuk menampilkan data jadwal
    public function render()
    {
        $jadwal = Jadwal::orderBy('hari')
            ->orderBy('jam_ke')
            ->get();

        return view('livewire.admin.jadwal.index', [
            'jadwal' => $jadwal,
        ]);
    }
    // public function render()
    // {
    //     return view('livewire.admin.jadwal.index');
    // }
}
