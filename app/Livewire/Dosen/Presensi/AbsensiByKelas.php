<?php

namespace App\Livewire\Dosen\Presensi;

use Livewire\Component;
use App\Models\Matakuliah;
use App\Models\Kelas;
use Livewire\WithPagination;
use App\Models\KRS;
use Illuminate\Support\Facades\Auth;

class AbsensiByKelas extends Component
{
    use WithPagination;

    public $matkul, $id_mata_kuliah, $url;

    public function mount($id_mata_kuliah)
    {
        // Ambil data mata kuliah berdasarkan id_mata_kuliah
        $this->matkul = Matakuliah::findOrFail($id_mata_kuliah);
    }

    public function render()
    {
        $this->url = request()->url();

        // Pastikan kode_mata_kuliah tidak kosong
        if (!$this->id_mata_kuliah) {
            return view('livewire.dosen.presensi.absensi-by-kelas', [
                'kelas' => collect(), // Mengembalikan koleksi kosong
            ]);
        }

        // Ambil mata kuliah berdasarkan kode dan NIDN dosen yang login
        $mataKuliah = MataKuliah::where('nidn', Auth::user()->nim_nidn)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->first();

        // Cek apakah data ditemukan
        if (!$mataKuliah) {
            return view('livewire.dosen.presensi.absensi-by-kelas', [
                'kelas' => collect(), // Kembalikan koleksi kosong jika tidak ada mata kuliah
            ]);
        }

        // Cari seluruh KRS pada prodi ini dan mata kuliah ini
        $krsEntries = KRS::where('id_mata_kuliah', $mataKuliah->id_mata_kuliah)
            ->where('id_prodi', $mataKuliah->prodi->id_prodi)
            ->pluck('NIM');

        // Ambil seluruh kelas berdasarkan array NIM
        $kelas = Kelas::whereIn('id_kelas', function ($query) use ($krsEntries) {
                $query->select('id_kelas')
                    ->from('mahasiswa')
                    ->whereIn('NIM', $krsEntries);
            })
            ->with(['prodi', 'semester'])
            ->distinct()
            ->get();

        return view('livewire.dosen.presensi.absensi-by-kelas', [
            'kelas' => $kelas,
        ]);
    }
}
