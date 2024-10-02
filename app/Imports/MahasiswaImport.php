<?php
namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use App\Models\Prodi; 

class MahasiswaImport implements ToModel, WithHeadingRow
{

    protected $skippedRecords = 0;
    protected $createdRecords = [];
    protected $incompleteRecords = [];
    private $rowNumber = 2;
    protected $requiredFields = ['nim', 'nama', 'tempat_lahir', 'tanggal_lahir', 'jenis_kelamin', 'nik', 'agama', 'alamat', 'jalur_pendaftaran', 'kewarganegaraan', 'jenis_pendaftaran', 'tanggal_masuk_kuliah', 'mulai_semester', 'jenis_tempat_tinggal', 'telp_rumah', 'no_hp', 'email', 'terima_kps', 'no_kps', 'jenis_transportasi', 'kode_prodi', 'kode_pt_asal', 'nama_pt_asal', 'kode_prodi_asal', 'nama_prodi_asal', 'jenis_pembiayaan', 'jumlah_biaya_masuk'];

    public function model(array $row)
    {
        $tanggalLahir = $this->convertExcelDate($row['tanggal_lahir']);
        $tanggalMasukKuliah = $this->convertExcelDate($row['tanggal_masuk_kuliah']);

        foreach ($this->requiredFields as $field) {
            if (empty($row[$field])) {
                $this->incompleteRecords[] = "Baris ke {$this->rowNumber} tidak lengkap, kolom {$field} tidak boleh kosong <br>";
                $this->rowNumber++;
                return null;
            }
        }
        if (!Prodi::where('kode_prodi', $row['kode_prodi'])->exists()) {
            $this->incompleteRecords[] = "kode_prodi {$row['kode_prodi']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
            $this->rowNumber++;
            return null; 
        }
        if ($this->isDuplicate($row['nim'], $row['nik'])) {
            $this->skippedRecords++;
            $this->rowNumber++;
            return null;
        } else {
            $this->createdRecords[] = "NIM = {$row['nim']} ,";
            $this->rowNumber++;
        }



        return new Mahasiswa([
            'id_orangtua_wali' => $row['id_orangtua_wali'],
            'id_user' => $row['id'] ?? null,
            'NIM' => $row['nim'],
            'nama' => $row['nama'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $tanggalLahir,
            'jenis_kelamin' => $row['jenis_kelamin'],
            'NIK' => $row['nik'],
            'agama' => $row['agama'],
            'alamat' => $row['alamat'],
            'jalur_pendaftaran' => $row['jalur_pendaftaran'],
            'kewarganegaraan' => $row['kewarganegaraan'],
            'jenis_pendaftaran' => $row['jenis_pendaftaran'],
            'tanggal_masuk_kuliah' => $tanggalMasukKuliah,
            'mulai_semester' => $row['mulai_semester'],
            'jenis_tempat_tinggal' => $row['jenis_tempat_tinggal'],
            'telp_rumah' => $row['telp_rumah'],
            'no_hp' => $row['no_hp'],
            'email' => $row['email'],
            'terima_kps' => $row['terima_kps'],
            'no_kps' => $row['no_kps'],
            'jenis_transportasi' => $row['jenis_transportasi'],
            'kode_prodi' => $row['kode_prodi'],
            'SKS_diakui' => $row['sks_diakui'],
            'kode_pt_asal' => $row['kode_pt_asal'],
            'nama_pt_asal' => $row['nama_pt_asal'],
            'kode_prodi_asal' => $row['kode_prodi_asal'],
            'nama_prodi_asal' => $row['nama_prodi_asal'],
            'jenis_pembiayaan' => $row['jenis_pembiayaan'],
            'jumlah_biaya_masuk' => $row['jumlah_biaya_masuk'],
        ]);
    }

    protected function isDuplicate($nim, $nik)
    {
        return Mahasiswa::where('NIM', $nim)->exists() || Mahasiswa::where('NIK', $nik)->exists();
    }

    protected function convertExcelDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            // If the date is numeric, it's likely an Excel date
            $dateTime = Date::excelToDateTimeObject($excelDate);
            return Carbon::instance($dateTime)->format('Y-m-d');
        }

        // If it's a string, try parsing it directly
        try {
            return Carbon::createFromFormat('d/m/Y', trim($excelDate))->format('Y-m-d');
        } catch (\Exception $e) {
            \Log::error('Date conversion error: ' . $e->getMessage());
            return null; // or set a default date
        }
    }

    // Method to get the skipped records
    public function getSkippedRecords()
    {
        return $this->skippedRecords;
    }
    public function getCreatedRecords()
    {
        return $this->createdRecords;
    }
    public function getIncompleteRecords()
    {
        return $this->incompleteRecords;
    }
}
