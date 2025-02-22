<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Presensi;
use App\Models\Mahasiswa;
use App\Models\KRS;
use App\Models\Token;
use Livewire\Component;

class DetailPresensi extends Component
{
    public $token;
    public $matkul;
    public $search;
    public $id_kelas;
    public $mahasiswa;
    public $mahasiswaPresensi;

    public function mount($token)
    {
        $this->token = Token::with('matkul')->where('token', $token)->first();

        if ($this->token) {
            $this->id_kelas = $this->token->id_kelas;
            $this->matkul = $this->token->matkul ? $this->token->matkul->nama_mata_kuliah : 'Mata kuliah tidak ditemukan';
            $this->updateMahasiswa(); // Panggil metode untuk inisialisasi mahasiswa
        } else {
            $this->matkul = 'Token tidak valid';
            $this->mahasiswa = collect(); // Kosongkan mahasiswa jika token tidak ditemukan
        }
    }

    public function updateMahasiswa()
    {
        $query = Mahasiswa::query();

        // Filter mahasiswa berdasarkan kelas
        $query->whereIn('NIM', KRS::where('id_kelas', $this->id_kelas)->pluck('NIM'));

        // Tambahkan filter pencarian jika ada
        if ($this->search) {
            $query->where(function ($subQuery) {
                $subQuery->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('NIM', 'like', '%' . $this->search . '%')
                    ->orWhereHas('prodi', function ($prodiQuery) {
                        $prodiQuery->where('nama_prodi', 'like', '%' . $this->search . '%');
                    })
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $this->mahasiswa = $query->get();

        // Update data presensi yang relevan
        $this->updatePresensiData();
    }

    public function updatePresensiData()
    {
        $presensi = Presensi::where('token', $this->token->token)->get();

        $this->mahasiswaPresensi = $this->mahasiswa->map(function ($mhs) use ($presensi) {
            $presensiData = $presensi->firstWhere('nim', $mhs->NIM);

            return [
                'id_presensi' => $presensiData ? $presensiData->id_presensi : null,
                'nama' => $mhs->nama,
                'nim' => $mhs->NIM,
                'waktu_submit' => $presensiData ? $presensiData->waktu_submit : null,
                'keterangan' => $presensiData ? $presensiData->keterangan : 'Belum Presensi',
                'alasan' => $presensiData ? $presensiData->alasan : '-',
            ];
        });
    }


    public function updatedSearch()
    {
        $this->updateMahasiswa(); // Perbarui mahasiswa saat search berubah
    }

    public function back()
    {
        return redirect()->route('dosen.presensi');
    }

    public function render()
    {
        $mahasiswa = Mahasiswa::whereIn('NIM', KRS::where('id_kelas', $this->id_kelas)->pluck('NIM'))->get();

        // Ambil presensi yang sesuai dengan token
        $presensi = Presensi::where('token', $this->token->token)->get();

        // Gabungkan mahasiswa dengan presensi
        $mahasiswaPresensi = $mahasiswa->map(function ($mhs) use ($presensi) {
            $presensiData = $presensi->firstWhere('nim', $mhs->NIM);

            return [
                'id_presensi' => $presensiData ? $presensiData->id_presensi : null,
                'nama' => $mhs->nama,
                'nim' => $mhs->NIM,
                'waktu_submit' => $presensiData ? $presensiData->waktu_submit : null,
                'keterangan' => $presensiData ? $presensiData->keterangan : 'Belum Presensi',
                'alasan' => $presensiData ? $presensiData->alasan : '-',
            ];
        });

        return view('livewire.dosen.presensi.detail_presensi', [
            'mahasiswaPresensi' => $mahasiswaPresensi,
        ]);
    }
}
