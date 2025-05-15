<?php

namespace App\Exports;

use App\Models\Presensi;
use App\Models\Mahasiswa;
use App\Models\KRS;
use App\Models\Token;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PresensiMahasiswaByToken implements FromCollection, WithHeadings
{
    protected $id_kelas;
    protected $id_token;
    protected $id_mata_kuliah;

    public function __construct($id_kelas, $id_token, $id_mata_kuliah)
    {
        $this->id_kelas = $id_kelas;
        $this->id_token = $id_token;
        $this->id_mata_kuliah = $id_mata_kuliah;
    }

    public function collection()
    {
        $nimList = KRS::where('id_kelas', $this->id_kelas)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->pluck('NIM');

        $mahasiswa = Mahasiswa::whereIn('NIM', $nimList)->get();

        $presensi = Presensi::where('id_token', $this->id_token)
            ->where('id_kelas', $this->id_kelas)
            ->where('id_mata_kuliah', $this->id_mata_kuliah)
            ->get();

        return $mahasiswa->map(function ($mhs) use ($presensi) {
            $presensiData = $presensi->firstWhere('nim', $mhs->NIM);

            return [
                $mhs->NIM,
                $mhs->nama,
                $presensiData ? $presensiData->waktu_submit : '-',
                $presensiData ? $presensiData->keterangan : 'Belum Presensi',
                $presensiData ? $presensiData->alasan : '-',
            ];
        });
    }

    public function headings(): array
    {
        return ['NIM', 'Nama', 'Waktu Submit', 'Keterangan', 'Alasan'];
    }
}

