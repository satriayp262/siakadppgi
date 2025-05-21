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
    protected $mataKuliah;

    public function __construct($nidn, $semester = null, $kelas = null, $mataKuliah = null)
    {
        $this->nidn = $nidn;
        $this->semester = $semester;
        $this->kelas = $kelas;
        $this->mataKuliah = $mataKuliah;
    }

    public function collection()
    {
        $query = BeritaAcara::with(['kelas', 'mataKuliah', 'dosen', 'semester'])
            ->where('nidn', $this->nidn);

        if ($this->semester) {
            $query->where('id_semester', $this->semester);
        }

        if ($this->kelas) {
            $query->where('id_kelas', $this->kelas);
        }

        if ($this->mataKuliah) {
            $query->where('id_mata_kuliah', $this->mataKuliah);
        }

        return $query->get()
            ->map(function ($beritaAcara) {
                return [
                    'Nama Dosen' => $beritaAcara->dosen->nama_dosen ?? '',
                    'NIDN' => $beritaAcara->nidn,
                    'Mata Kuliah' => $beritaAcara->mataKuliah->nama_mata_kuliah ?? '',
                    'Kelas' => $beritaAcara->kelas->nama_kelas ?? '',
                    'Semester' => $beritaAcara->semester->nama_semester ?? '',
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
