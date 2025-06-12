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
    public $tokenString; // Menyimpan string token asli dari parameter

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

        // 4. Ambil data mahasiswa dan presensi
        $this->loadData();
    }

    protected function loadData()
    {
        // 1. Ambil mahasiswa berdasarkan kelas dari token
        $this->mahasiswa = Mahasiswa::whereIn('NIM', function ($query) {
            $query->select('NIM')
                ->from('krs')
                ->where('id_kelas', $this->tokenData->id_kelas);
        })->orderBy('nama')->get();

        // 2. Ambil data presensi spesifik untuk token ini
        $presensi = Presensi::where('token', $this->tokenData->token)
            ->where('id_mata_kuliah', $this->tokenData->id_mata_kuliah)
            ->get();

        // 3. Gabungkan data
        $this->mahasiswaPresensi = $this->mahasiswa->map(function ($mhs) use ($presensi) {
            $presensiData = $presensi->firstWhere('nim', $mhs->NIM);

            return [
                'id_presensi' => $presensiData?->id,
                'nama' => $mhs->nama,
                'nim' => $mhs->NIM,
                'waktu_submit' => $presensiData?->waktu_submit,
                'keterangan' => $presensiData?->keterangan ?? 'Belum Presensi',
                'alasan' => $presensiData?->alasan ?? '-',
            ];
        })->toArray();
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

    #[On('presensiUpdated')]
    public function handlePresensiUpdated()
    {
        $this->dispatch('updated', params: ['message' => 'Presensi berhasil diedit']);
        $this->loadData(); // Refresh data setelah update
    }

    public function updatedSearch()
    {
        $this->loadData(); // Reload data dengan filter pencarian
    }

    public function back()
    {
        return redirect()->to(route('dosen.presensiByToken'));
    }

    public function render()
    {
        return view('livewire.dosen.presensi.detail_presensi', [
            'mahasiswaPresensi' => $this->mahasiswaPresensi,
            'matkul' => $this->matkul
        ]);
    }
}
