<?php

namespace App\Livewire\Dosen\Presensi;

use Livewire\Component;
use App\Models\Token;
use App\Models\Matakuliah;
use App\Models\Kelas;
use App\Models\Semester;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CreateToken extends Component
{
    public $id_mata_kuliah, $nama_mata_kuliah;
    public $id_kelas, $nama_kelas;
    public $id_jadwal;
    public $valid_until;
    public $pertemuan;

    public bool $isWaktuAktif = false; // ✅ Untuk tombol "Buat Token"

    protected $rules = [
        'pertemuan' => 'required|integer|min:1|max:16',
    ];

    public function mount()
    {
        // Set zona waktu ke Asia/Jakarta
        date_default_timezone_set('Asia/Jakarta');
        Carbon::setLocale('id');
        setlocale(LC_TIME, 'id_ID.utf8', 'id_ID', 'IND');

        if ($this->id_mata_kuliah) {
            $matkul = Matakuliah::find($this->id_mata_kuliah);
            $this->nama_mata_kuliah = $matkul?->nama_mata_kuliah;
        }

        if ($this->id_kelas) {
            $kelas = Kelas::find($this->id_kelas);
            $this->nama_kelas = $kelas?->nama_kelas;
        }

        // Cek apakah sekarang adalah waktu aktif jadwal
        $now = Carbon::now('Asia/Jakarta');
        $hari = $now->translatedFormat('l'); // Senin, Selasa, dst
        $jam = $now->format('H:i:s');

        $jadwal = Jadwal::where('nidn', Auth::user()->nim_nidn)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->where('id_kelas', $this->id_kelas)
            ->where('hari', $hari)
            ->whereTime('jam_mulai', '<=', $jam)
            ->whereTime('jam_selesai', '>=', $jam)
            ->first();

        if ($jadwal) {
            $this->id_jadwal = $jadwal->id_jadwal;
            $this->valid_until = Carbon::today('Asia/Jakarta')->setTimeFromTimeString($jadwal->jam_selesai);
            $this->isWaktuAktif = true; // ✅ Jadwal aktif
        } else {
            $this->isWaktuAktif = false; // ❌ Tidak ada jadwal aktif saat ini
        }
    }

    public function save()
    {
        $this->validate();

        $semesterAktif = Semester::where('is_active', 1)->first();
        if (!$semesterAktif) {
            $this->reset();
            $this->dispatch('noSemesterActive');
            return;
        }

        if (!$this->id_jadwal) {
            $this->dispatch('noScheduleFound');
            return;
        }

        // Cek token duplikat
        $cekToken = Token::where('id_jadwal', $this->id_jadwal)
            ->where('pertemuan', $this->pertemuan)
            ->exists();

        if ($cekToken) {
            $this->dispatch('pertemuanSudahAda');
            return;
        }

        $token = strtoupper(Str::random(6));

        Token::create([
            'token' => $token,
            'id_mata_kuliah' => $this->id_mata_kuliah,
            'id_kelas' => $this->id_kelas,
            'id_semester' => $semesterAktif->id_semester,
            'id_jadwal' => $this->id_jadwal,
            'pertemuan' => $this->pertemuan,
            'id' => Auth::user()->id,
            'valid_until' => $this->valid_until,
        ]);

        $this->reset(['pertemuan']);

        $this->dispatch('tokenSuccessfullyCreated');
    }

    public function render()
    {
        return view('livewire.dosen.presensi.create-token');
    }
}
