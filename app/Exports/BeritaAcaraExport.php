<?php

namespace App\Exports;

use App\Models\BeritaAcara;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BeritaAcaraExport implements FromCollection, WithHeadings
{
    protected $nidn;
    protected $semester;
    protected $kelas;
    protected $matakuliah;

    public function __construct($nidn, $semester = null, $kelas = null, $matakuliah = null)
    {
        $this->nidn = $nidn;
        $this->semester = $semester;
        $this->kelas = $kelas;
        $this->matakuliah = $matakuliah;
    }

    public function collection()
    {
        return BeritaAcara::with(['kelas', 'mataKuliah', 'dosen'])
            ->when($this->nidn, function ($query) {
                $query->where('nidn', $this->nidn);
            })
            ->when($this->semester, function ($query) {
                $query->where('id_semester', $this->semester);
            })
            ->when($this->kelas, function ($query) {
                $query->where('id_kelas', $this->kelas);
            })
            ->when($this->matakuliah, function ($query) {
                $query->where('id_mata_kuliah', $this->matakuliah);
            })
            ->get()
            ->map(function ($beritaAcara) {
                return [
                    'Nama Dosen' => $beritaAcara->dosen->nama ?? '',
                    'NIDN' => $beritaAcara->nidn,
                    'Mata Kuliah' => $beritaAcara->mataKuliah->nama_mata_kuliah ?? '',
                    'Kelas' => $beritaAcara->kelas->nama_kelas ?? '',
                    'Semester' => $beritaAcara->semester ?? '',
                    'Tanggal' => $beritaAcara->tanggal ?? '',
                    'Materi' => $beritaAcara->materi ?? '',
                    'Jumlah Mahasiswa' => $beritaAcara->jumlah_mahasiswa ?? '',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Nama Dosen',
            'NIDN',
            'Mata Kuliah',
            'Kelas',
            'Semester',
            'Tanggal',
            'Materi',
            'Jumlah Mahasiswa',
        ];
    }
}
