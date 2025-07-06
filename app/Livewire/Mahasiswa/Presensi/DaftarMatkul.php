<?php

namespace App\Livewire\Mahasiswa\Presensi;

use App\Models\Krs;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class DaftarMatkul extends Component
{
    public $search = '';

    public function mount()
    {
        $this->search = '';
    }

    

    public function render()
    {
        $nim = Auth::user()->nim_nidn;
        $today = Carbon::now()->locale('id')->dayName;

        $matkuls = DB::table('krs')
            ->join('jadwal', function ($join) {
                $join->on('krs.id_mata_kuliah', '=', 'jadwal.id_mata_kuliah')
                    ->on('krs.id_kelas', '=', 'jadwal.id_kelas');
            })
            ->join('matkul', 'krs.id_mata_kuliah', '=', 'matkul.id_mata_kuliah')
            ->join('kelas', 'krs.id_kelas', '=', 'kelas.id_kelas')
            ->where('krs.nim', $nim)
            ->where('jadwal.hari', $today)
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('matkul.nama_mata_kuliah', 'like', '%' . $this->search . '%')
                      ->orWhere('matkul.kode_mata_kuliah', 'like', '%' . $this->search . '%')
                      ->orWhere('jadwal.grup', 'like', '%' . $this->search . '%');
                });
            })
            ->select(
                'krs.*',
                'matkul.nama_mata_kuliah',
                'matkul.kode_mata_kuliah',
                'jadwal.jam_mulai',
                'jadwal.jam_selesai',
                'jadwal.grup'
            )
            ->get();

        return view('livewire.mahasiswa.presensi.daftar-matkul', [
            'matkuls' => $matkuls
        ]);
    }
}
