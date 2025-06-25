<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Presensi;
use App\Models\Mahasiswa;
use App\Models\KRS;
use App\Models\Token;
use Livewire\Component;
use Livewire\Attributes\On;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PresensiMahasiswaByToken;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class DetailPresensi extends Component
{
    public $tokenData; // Data token yang dipilih
    public $matkul;
    public $search = '';
    public $id_kelas;
    public $mahasiswa;
    public $mahasiswaPresensi = [];
    public $tokenString;

    public function mount($token)
    {
        $this->tokenString = $token; // Simpan token dari parameter

        // 1. Ambil data token dengan relasi lengkap
        $this->tokenData = Token::with(['matkul', 'kelas'])
            ->where('token', $token)
            ->first();

        if (!$this->tokenData) {
            Log::error("Token tidak ditemukan", ['token' => $token]);
            session()->flash('error', 'Token tidak valid');
            return redirect()->route('dosen.presensi');
        }

        // 2. Verifikasi data token
        Log::info("Token ditemukan", [
            'id' => $this->tokenData->id,
            'token' => $this->tokenData->token,
            'matkul' => $this->tokenData->matkul->nama_mata_kuliah ?? null,
            'kelas' => $this->tokenData->kelas->nama_kelas ?? null
        ]);

        // 3. Set data dasar
        $this->id_kelas = $this->tokenData->id_kelas;
        $this->matkul = $this->tokenData->matkul->nama_mata_kuliah ?? 'Mata kuliah tidak ditemukan';
    }

    public function exportExcel()
    {
        // Gunakan token dari route parameter yang sudah disimpan di mount()
        $token = $this->tokenString;

        // Cari data token lagi untuk memastikan masih valid
        $tokenData = Token::with(['matkul', 'kelas'])
            ->where('token', $token)
            ->first();

        if (!$tokenData) {
            session()->flash('error', 'Token tidak valid');
            return back();
        }

        return Excel::download(
            new PresensiMahasiswaByToken(
                $tokenData->id_kelas,
                $tokenData->token,
                $tokenData->id_mata_kuliah
            ),
            'presensi_' . $token . '_' . now()->format('Ymd_His') . '.xlsx'
        );
    }

    #[On('presensi-updated')]
    public function handlePresensiUpdated()
    {
        $this->dispatch('pg:eventRefresh-detail-presensi-table');
        $this->dispatch('close-modal');
        $this->js(
            "
                Swal.fire({
                    title: 'Sukses!',
                    text: 'Data presensi berhasil diperbarui',
                    icon: 'success',
                    confirmButtonText: 'OK'
                });"
        );
        // dd($this->mahasiswaPresensi);
    }

    public function back()
    {
        return redirect()->to(route('dosen.presensiByToken'));
    }

    public function render()
    {
        return view('livewire.dosen.presensi.detail_presensi', [
            'mahasiswaPresensi' => $this->mahasiswaPresensi,
            'matkul' => $this->matkul,
            'token' => $this->tokenString, // kirim token ke view
        ]);
    }
}
