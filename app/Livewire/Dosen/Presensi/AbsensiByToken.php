<?php

namespace App\Livewire\Dosen\Presensi;

use Livewire\Component;
use App\Models\Token;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\WithPagination;

class AbsensiByToken extends Component
{
    use WithPagination;

    public $search = '';
    public $id_kelas, $CheckDosen = false;
    public $id_mata_kuliah;
    public $kelas;
    public $matkul;

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
    }

    public function render()
    {
        $tokens = Token::query()
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->where('id_kelas', $this->id_kelas)
            ->whereHas('matkul', function ($query) {
                $query->where('nidn', Auth()->user()->nim_nidn)
                    ->where(function ($query) {
                        $query->where('nama_mata_kuliah', 'like', '%' . $this->search . '%')
                            ->orWhere('id_mata_kuliah', 'like', '%' . $this->search . '%');
                    });
            })
            ->where(function ($query) {
                $query->orWhere('valid_until', 'like', '%' . $this->search . '%')
                    ->orWhere('created_at', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.dosen.presensi.absensi-by-token', [
            'kelas' => $this->kelas,
            'matkul' => $this->matkul,
            'tokens' => $tokens,
        ]);
    }
}
