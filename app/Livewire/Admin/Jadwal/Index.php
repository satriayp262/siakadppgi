<?php

namespace App\Livewire\Admin\Jadwal;

use App\Livewire\Staff\Tagihan\Update;
use App\Models\komponen_kartu_ujian;
use Livewire\Component;
use App\Models\Kelas;
use App\Models\Ruangan;
use App\Models\Jadwal;
use App\Models\Matakuliah;
use App\Models\Prodi;
use App\Models\KRS;
use App\Models\request_dosen;
use App\Models\Semester;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\On;

class Index extends Component
{
    public $id_kelas;
    public $hari;
    public $jam_mulai;
    public $jam_selesai;
    public $sesi;
    public $id_ruangan;
    public $prodi;
    public $Semester;
    public $semesterfilter;
    public $ujian;
    public $jenis;
    public $batas;

    #[On('ruanganUpdated')]
    public function handleruanganUpdated()
    {
        // $this->dispatch('pg:eventRefresh-ruangan-table-lw2rml-table');
        $this->dispatch('updated', params: ['message' => 'Ruangan berhasil diubah!']);
    }

    public function pilihSemester()
    {
        // Validasi input
        $this->validate([
            'Semester' => 'required',
            'batas' => 'required',
        ], [
            'Semester.required' => 'Semester harus dipilih.',
            'batas.required' => 'Tanggal batas pengajuan wajib diisi.',
        ]);

        // Cek apakah ada kelas untuk semester yang dipilih
        $kelasCount = KRS::where('id_semester', $this->Semester)->count();

        if ($kelasCount === 0) {
            $this->dispatchBrowserEvent('show-message', [
                'type' => 'warning',
                'message' => 'Tidak ada kelas yang terdaftar untuk semester ini.'
            ]);
            return;
        }

        // Jalankan proses generate
        $this->generate();
    }


    public function generate()
    {
        $this->batas;
        $idKelasAktif = KRS::where('id_semester', $this->Semester)
            ->pluck('id_kelas')
            ->unique();

        $kelasByProdi = Kelas::with('prodi')
            ->whereIn('id_kelas', $idKelasAktif)
            ->get()
            ->shuffle()
            ->groupBy('kode_prodi');

        $ruanganList = Ruangan::all();
        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'];
        $timeSlots = [
            ['sesi' => 1, 'jam_mulai' => '08:00', 'jam_selesai' => '09.30'],
            ['sesi' => 2, 'jam_mulai' => '09.30', 'jam_selesai' => '11.00'],
            ['sesi' => 3, 'jam_mulai' => '11.00', 'jam_selesai' => '12.30'],
            ['sesi' => 4, 'jam_mulai' => '12.30', 'jam_selesai' => '14.00'],
            ['sesi' => 5, 'jam_mulai' => '14.00', 'jam_selesai' => '15.30'],
            ['sesi' => 6, 'jam_mulai' => '15.30', 'jam_selesai' => '17.00'],
            ['sesi' => 7, 'jam_mulai' => '17.00', 'jam_selesai' => '18.30'],
            ['sesi' => 8, 'jam_mulai' => '18.30', 'jam_selesai' => '20.00']
        ];

        foreach ($kelasByProdi as $prodi => $kelasList) {
            foreach ($kelasList as $kelas) {

                $jumlahMahasiswa = KRS::where('id_kelas', $kelas->id_kelas)->count();
                $ruanganTetap = null;

                foreach ($ruanganList as $room) {
                    $isRoomAvailable = !Jadwal::where('id_ruangan', $room->id_ruangan)->exists();
                    if ($room->kapasitas >= $jumlahMahasiswa && $isRoomAvailable) {
                        $ruanganTetap = $room;
                        break;
                    }
                }


                foreach (Matakuliah::where('kode_prodi', $kelas->kode_prodi)->get() as $matkul) {
                    $ruangan = ($matkul->metode_pembelajaran == 'Online') ? 'Online' : $ruanganTetap;

                    foreach ($days as $day) {
                            // Batasi maksimal 2 mata kuliah per hari per kelas
                            $existingMatkulCount = Jadwal::where('id_kelas', $kelas->id_kelas)
                                ->where('hari', $day)
                                ->count();

                            if ($existingMatkulCount >= 3) {
                                continue;
                            }

                            if ($matkul->jenis_mata_kuliah == 'P') {
                                for ($i = 0; $i < count($timeSlots) - 1; $i++) {
                                    $firstSlot = $timeSlots[$i];
                                    $secondSlot = $timeSlots[$i + 1];

                                    $totalSesiHariIni = Jadwal::where('id_kelas', $kelas->id_kelas)
                                        ->where('hari', $day)
                                        ->count();

                                    if ($totalSesiHariIni >= 2) {
                                        continue;
                                    }

                                    // Cek apakah dua sesi ini berurutan dan tidak bentrok
                                    $conflict = Jadwal::where(function ($query) use ($kelas, $matkul, $firstSlot, $secondSlot, $day) {
                                        $query->where('id_kelas', $kelas->id_kelas)
                                            ->orWhere('nidn', $matkul->nidn);
                                    })
                                        ->whereIn('sesi', [$firstSlot['sesi'], $secondSlot['sesi']])
                                        ->where('hari', $day)
                                        ->exists();

                                    if (!$conflict) {
                                        if ($ruangan) {

                                            // Buat dua entri jadwal dengan grup A dan B
                                            Jadwal::create([
                                                'id_kelas' => $kelas->id_kelas,
                                                'id_mata_kuliah' => $matkul->id_mata_kuliah,
                                                'nidn' => $matkul->nidn,
                                                'kode_prodi' => $prodi,
                                                'id_semester' => $this->Semester,
                                                'hari' => $day,
                                                'jam_mulai' => $firstSlot['jam_mulai'],
                                                'jam_selesai' => $firstSlot['jam_selesai'],
                                                'sesi' => $firstSlot['sesi'],
                                                'id_ruangan' => ($ruangan == 'Online') ? 'Online' : $ruangan->id_ruangan,
                                                'grup' => 'A', // butuh kolom tambahan di tabel
                                                'batas_pengajuan' => $this->batas
                                            ]);

                                            Jadwal::create([
                                                'id_kelas' => $kelas->id_kelas,
                                                'id_mata_kuliah' => $matkul->id_mata_kuliah,
                                                'nidn' => $matkul->nidn,
                                                'kode_prodi' => $prodi,
                                                'id_semester' => $this->Semester,
                                                'hari' => $day,
                                                'jam_mulai' => $secondSlot['jam_mulai'],
                                                'jam_selesai' => $secondSlot['jam_selesai'],
                                                'sesi' => $secondSlot['sesi'],
                                                'id_ruangan' => ($ruangan == 'Online') ? 'Online' : $ruangan->id_ruangan,
                                                'grup' => 'B',
                                                'batas_pengajuan' => $this->batas
                                            ]);

                                            // (Opsional) Simpan data grup ke tabel pivot krs_praktikum jika kamu ingin tahu siapa di grup A/B
                                            // Contoh: foreach ($grupA as $mhs) { KrsPraktikum::create([...]); }

                                            break 2; // sudah terjadwal
                                        }
                                    }
                                }
                            } else {
                                foreach ($timeSlots as $timeSlot) {
                                    // Cek apakah sesi ini sudah digunakan dalam kelas atau oleh dosen
                                    $conflict = Jadwal::where(function ($query) use ($kelas, $matkul, $timeSlot, $day) {
                                        $query->where('id_kelas', $kelas->id_kelas)
                                            ->orWhere('nidn', $matkul->nidn);
                                    })
                                        ->where('sesi', $timeSlot['sesi'])
                                        ->where('hari', $day)
                                        ->exists();

                                    if (!$conflict) {


                                        if ($ruangan) {
                                            Jadwal::create([
                                                'id_kelas' => $kelas->id_kelas,
                                                'id_mata_kuliah' => $matkul->id_mata_kuliah,
                                                'nidn' => $matkul->nidn,
                                                'kode_prodi' => $prodi,
                                                'id_semester' => $this->Semester,
                                                'hari' => $day,
                                                'jam_mulai' => $timeSlot['jam_mulai'],
                                                'jam_selesai' => $timeSlot['jam_selesai'],
                                                'sesi' => $timeSlot['sesi'],
                                                'id_ruangan' => ($ruangan == 'Online') ? 'Online' : $ruangan->id_ruangan,
                                                'batas_pengajuan' => $this->batas
                                            ]);
                                            break 2; // Berhenti setelah satu mata kuliah dijadwalkan
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        $this->dispatch('created', ['message' => 'Jadwal Berhasil Dibuat']);
    }


    public function destroy2()
    {
        Jadwal::truncate();
        komponen_kartu_ujian::query()->update(['tanggal_dibuat' => null]);
        request_dosen::truncate();
        $this->dispatch('destroyed', ['message' => 'Jadwal Berhasil Dihapus']);
    }

    public function destroy($id_jadwal)
    {
        $jadwal = Jadwal::find($id_jadwal);

        // Hapus data jadwal
        $jadwal->delete();

        // Tampilkan pesan sukses
        $this->dispatch('destroyed', ['message' => 'Jadwal Berhasil Dihapus']);
    }

    public function generatePdf()
    {
        $jadwals = Jadwal::orderBy('id_kelas', direction: 'asc')
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy(column: 'sesi', direction: 'asc')
            ->get();

        $prodis = Prodi::all();

        $data = [
            'jadwals' => $jadwals,
            'prodis' => $prodis
        ];

        $pdf = PDF::loadView('livewire.admin.jadwal.download', $data);


        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'Jadwal Perkulihan Semester ' . $jadwals[0]->semester->nama_semester . '.pdf');
    }

    public function render()
    {
        $jadwals = Jadwal::orderBy('id_kelas', direction: 'asc')
            ->orderByRaw("FIELD(hari, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat')")
            ->orderBy(column: 'sesi', direction: 'asc')
            ->get();

        if ($this->semesterfilter) {
            $jadwals = $jadwals->where('id_semester', $this->semesterfilter);
        }

        $prodis = Prodi::all();

        if ($this->prodi) {
            $jadwals = $jadwals->where('kode_prodi', $this->prodi);
        }

        $semesters = Semester::orderByRaw('LEFT(nama_semester, 4) DESC')
                            ->orderByRaw('RIGHT(nama_semester, 1) DESC')
                            ->take(12)
                            ->get();

        $semesterfilters = Semester::orderByRaw('LEFT(nama_semester, 4) DESC')
                                    ->orderByRaw('RIGHT(nama_semester, 1) DESC')
                                    ->get();

        $request = request_dosen::all();

        return view('livewire.admin.jadwal.index', [
            'jadwals' => $jadwals,
            'prodis' => $prodis,
            'semesters' => $semesters,
            'semesterfilters' => $semesterfilters,
            'request' => $request
        ]);
    }
}
