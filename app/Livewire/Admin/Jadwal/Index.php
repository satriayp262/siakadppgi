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
use App\Models\Semester;
use Carbon\Carbon;
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


    public function pilihSemester($semesterId)
    {
        // Menetapkan semester yang dipilih
        $this->Semester = $semesterId;

        // Cek apakah ada kelas dengan semester yang dipilih
        $kelasCount = Kelas::where('id_semester', $this->Semester)->count();

        if ($kelasCount === 0) {
            // Jika tidak ada kelas yang sesuai dengan semester, tampilkan pesan error
            $this->dispatch('warning', ['message' => 'Tidak ada kelas yang terdaftar untuk semester ini']);
            return; // Hentikan eksekusi lebih lanjut
        }else{
            // Setelah memilih semester, panggil generate
            $this->generate();
        }

    }

    public function rules()
    {
        return [
            'jenis' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'jenis.required' => 'Jenis Ujian harus dipilih'
        ];
    }

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

    public function clear2()
    {
        jadwal::query()->update(['jenis_ujian' => null]);

        $this->dispatch('destroyed', ['message' => 'jenis Ujian Deleted Successfully']);
    }

    public function clear()
    {
        jadwal::query()->update(['tanggal' => null]);

        $this->dispatch('destroyed', ['message' => 'tanggal Ujian Deleted Successfully']);
    }


    public function generate()
    {
        $kelasByProdi = Kelas::with('prodi')
            ->where('id_semester', $this->Semester)
            ->get()
            ->shuffle()
            ->groupBy('kode_prodi');

        $ruanganList = Ruangan::all();
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
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
                $kelasSchedule = []; // Menyimpan jumlah mata kuliah per hari

                // Cek apakah ruangan tersedia
                $jumlahMahasiswa = KRS::where('id_kelas', $kelas->id_kelas)->count();
                $ruangan = null;

                if ($kelas->mode_kuliah == 'O') {
                    $ruangan = 'Online';
                } else {
                    foreach ($ruanganList as $room) {
                        $isRoomAvailable = !Jadwal::where('id_ruangan', $room->id_ruangan)
                        ->exists();


                        if ($room->kapasitas >= $jumlahMahasiswa && $isRoomAvailable) {
                            $ruangan = $room;
                            break;
                        }
                    }
                }

                foreach (Matakuliah::where('kode_prodi', $kelas->kode_prodi)->get() as $matkul) {
                    foreach ($days as $day) {
                        // Batasi maksimal 2 mata kuliah per hari per kelas
                        $existingMatkulCount = Jadwal::where('id_kelas', $kelas->id_kelas)
                            ->where('hari', $day)
                            ->count();

                        if ($existingMatkulCount >= 2) {
                            continue;
                        }

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
                                    ]);
                                    break 2; // Berhenti setelah satu mata kuliah dijadwalkan
                                }
                            }
                        }
                    }
                }
            }
        }

        $this->dispatch('created', ['message' => 'Jadwal Created Successfully']);
    }


    public function destroy2()
    {
        Jadwal::truncate();
        komponen_kartu_ujian::query()->update(['tanggal_dibuat' => null]);
        $this->dispatch('destroyed', ['message' => 'Jadwal Deleted Successfully']);
    }

    public function destroy($id_jadwal)
    {
        $jadwal = Jadwal::find($id_jadwal);

        // Hapus data jadwal
        $jadwal->delete();

        // Tampilkan pesan sukses
        $this->dispatch('destroyed', ['message' => 'jadwal Deleted Successfully']);
    }

    #[On('jadwalUpdated')]
    public function x()
    {
        $this->dispatch('created', ['message' => 'Jadwal Switched Successfully']);
    }

    #[On('jadwalUpdated2')]
    public function z()
    {
        $this->dispatch('created', ['message' => 'Jadwal Edited Successfully']);
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

        return view('livewire.admin.jadwal.index', [
            'jadwals' => $jadwals,
            'prodis' => $prodis,
            'semesters' => $semesters,
            'semesterfilters' => $semesterfilters
        ]);
    }
}
