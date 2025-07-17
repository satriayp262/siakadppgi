<?php

namespace App\Livewire\Dosen\Presensi;

use Livewire\Component;
use App\Models\Token;
use App\Models\Matakuliah;
use App\Models\Kelas;
use App\Models\Jadwal;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Carbon\Carbon;

class AbsensiByToken extends Component
{
    use WithPagination;

    public $search = '';
    public $id_kelas, $CheckDosen = false;
    public $id_mata_kuliah;
    public $kelas;
    public $matkul;
    public $token;

    public $jadwal;
    public $tokenBisaDibuat = false;

    #[On('tokenSuccessfullyCreated')]
    public function handleTokenSuccessfullyCreated($token, $message)
    {
        $this->dispatch('pg:eventRefresh-token-table');
        $this->dispatch('createdTokenSuccess', params: ['message' => 'Token berhasil dibuat.']);
    }

    #[On('acaraCreated')]
    public function handleAcaraUpdated()
    {
        $this->dispatch('pg:eventRefresh-berita-acara-dosen-table');
        $this->dispatch('pg:eventRefresh-token-table');
        $this->dispatch('created', params: ['message' => 'Berita Acara berhasil dibuat.']);
    }

    #[On('noSemesterActive')]
    public function handleNoSemesterActive()
    {
        $this->dispatch('createdTokenFailed', params: ['message' => 'Tidak ada semester aktif saat ini.']);
    }

    #[On('noScheduleFound')]
    public function handleNoScheduleFound()
    {
        $this->dispatch('createdTokenFailed', params: ['message' => 'Jadwal tidak ditemukan untuk dosen ini.']);
    }

    #[On('notWithinAllowedTime')]
    public function handleNotWithinAllowedTime()
    {
        $this->dispatch('createdTokenFailed', params: ['message' => 'Token hanya dapat dibuat sesuai jadwal dan waktu yang ditentukan.']);
    }

    public function mount($id_kelas, $id_mata_kuliah)
    {
        $this->id_kelas = $id_kelas;
        $this->id_mata_kuliah = $id_mata_kuliah;

        $this->kelas = Kelas::with('matkul')->findOrFail($id_kelas);
        $this->matkul = Matakuliah::findOrFail($id_mata_kuliah);

        // Ambil jadwal sesuai dosen, mata kuliah, dan kelas
        $this->jadwal = Jadwal::where('id_kelas', $id_kelas)
            ->where('id_mata_kuliah', $id_mata_kuliah)
            ->where('nidn', Auth::user()->nim_nidn)
            ->first();

        if ($this->jadwal) {
            $now = Carbon::now('Asia/Jakarta');
            $hariIni = $now->isoFormat('dddd'); // contoh: "Senin"

            // Cek hari + jam
            if (
                strtolower($this->jadwal->hari) === strtolower($hariIni) &&
                $now->between(
                    Carbon::createFromFormat('H:i:s', $this->jadwal->jam_mulai),
                    Carbon::createFromFormat('H:i:s', $this->jadwal->jam_selesai)
                )
            ) {
                $this->tokenBisaDibuat = true;
            }
        }
    }

    public function render()
    {
        return view('livewire.dosen.presensi.absensi-by-token', [
            'kelas' => $this->kelas,
            'matkul' => $this->matkul,
            'tokenBisaDibuat' => $this->tokenBisaDibuat,
        ]);
    }
}
