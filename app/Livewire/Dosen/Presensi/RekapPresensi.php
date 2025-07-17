<?php

namespace App\Livewire\Dosen\Presensi;

use App\Models\Presensi;
use App\Models\Token;
use App\Models\Kelas;
use App\Models\MataKuliah;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class RekapPresensi extends Component
{
    public $id_mata_kuliah;
    public $id_kelas;

    public MataKuliah $matkul;
    public Kelas $kelas;

    public function mount($id_mata_kuliah, $id_kelas)
    {
        $this->id_mata_kuliah = $id_mata_kuliah;
        $this->id_kelas = $id_kelas;

        $this->matkul = MataKuliah::findOrFail($id_mata_kuliah);
        $this->kelas = Kelas::with('semester')->findOrFail($id_kelas);
    }

    public function render()
    {
        $tokens = Token::where('id_mata_kuliah', $this->id_mata_kuliah)
            ->where('id_kelas', $this->id_kelas)
            ->get()
            ->keyBy('pertemuan');

        $jumlahPertemuan = range(1, 16);

        $rekap = [
            'Hadir' => [],
            'Ijin' => [],
            'Sakit' => [],
            'Alpha' => [],
        ];

        foreach (['Hadir', 'Ijin', 'Sakit', 'Alpha'] as $status) {
            foreach ($jumlahPertemuan as $pertemuan) {
                $token = optional($tokens->get($pertemuan))->token;

                $rekap[$status][$pertemuan] = $token
                    ? Presensi::where('token', $token)->where('keterangan', $status)->count()
                    : 0;
            }
        }

        return view('livewire.dosen.presensi.rekap-presensi', [
            'rekap' => $rekap,
            'jumlahPertemuan' => $jumlahPertemuan,
            'matkul' => $this->matkul,
            'kelas' => $this->kelas,
        ]);
    }
}
