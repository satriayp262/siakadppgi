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
    public $id_mata_kuliah, $matkul, $nama_mata_kuliah;
    public $id_kelas, $nama_kelas;
    public $id_semester;
    public $valid_until;
    public $pertemuan;

    protected $rules = [
        'id_mata_kuliah' => 'required|exists:matkul,id_mata_kuliah',
        'id_kelas' => 'required|exists:kelas,id_kelas',
        'valid_until' => 'required|date|after:now',
        'pertemuan' => 'required|integer|min:1|max:16',
    ];

    public function mount()
    {
        if ($this->id_mata_kuliah) {
            $matkul = Matakuliah::find($this->id_mata_kuliah);
            if ($matkul) {
                $this->nama_mata_kuliah = $matkul->nama_mata_kuliah;
            }
        }

        if ($this->id_kelas) {
            $kelas = Kelas::find($this->id_kelas);
            if ($kelas) {
                $this->nama_kelas = $kelas->nama_kelas;
            }
        }
    }

    public function save()
    {
        $this->validate();

        $semesterAktif = Semester::where('is_active', 1)->first();
        if (!$semesterAktif) {
            $this->reset();
            $this->dispatch('noSemesterActive', ['message' => 'Tidak ada semester aktif.']);
            return;
        }

        $hariSekarang = Carbon::now()->translatedFormat('l');

        $jadwal = Jadwal::where('id_kelas', $this->id_kelas)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->where('nidn', Auth::user()->nim_nidn)
            ->where('hari', $hariSekarang)
            ->first();

        if (!$jadwal) {
            $this->reset();
            $this->dispatch('noScheduleFound', ['message' => 'Jadwal tidak ditemukan untuk hari ini.']);
            return;
        }

        $now = Carbon::now();
        $jamMulai = Carbon::createFromFormat('H:i:s', $jadwal->jam_mulai)->setDate($now->year, $now->month, $now->day)->subMinutes(15);
        $jamSelesai = Carbon::createFromFormat('H:i:s', $jadwal->jam_selesai)->setDate($now->year, $now->month, $now->day);

        if (!$now->between($jamMulai, $jamSelesai)) {
            $this->reset();
            $this->dispatch('notWithinAllowedTime', ['message' => 'Token hanya dapat dibuat 15 menit sebelum sampai akhir sesi.']);
            return;
        }

        $token = Str::upper(Str::random(6));

        Token::create([
            'token' => $token,
            'id_mata_kuliah' => $this->id_mata_kuliah,
            'id_kelas' => $this->id_kelas,
            'id_semester' => $semesterAktif->id_semester,
            'valid_until' => $this->valid_until,
            'hari' => $hariSekarang,
            'sesi' => $jadwal->sesi,
            'pertemuan' => $this->pertemuan,
            'id' => Auth::user()->id,
        ]);

        $this->reset();

        $this->dispatch('tokenSuccessfullyCreated', [
            'token' => $token,
            'message' => 'Token berhasil dibuat.'
        ]);
    }

    public function render()
    {
        return view('livewire.dosen.presensi.create-token');
    }
}
