<?php
namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Carbon\Carbon;
use App\Models\Orangtua_Wali;
use App\Models\Prodi;
use App\Models\Semester;
use App\Models\User;
use Hash;

class MahasiswaImport implements ToModel, WithHeadingRow
{

    protected $skippedRecords = 0;
    protected $createdRecords = [];
    protected $incompleteRecords = [];
    private $rowNumber = 2;
    protected $requiredFields = [
        'nim',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'nik',
        'agama',
        'kelurahan',
        'kecamatan',
        'jalur_pendaftaran',
        'kewarganegaraan',
        'jenis_pendaftaran',
        'tanggal_masuk_kuliah',
        'mulai_semester',
        'jenis_tinggal',
        'telp_rumah',
        'no_hp',
        'email',
        'terima_kps',
        'alat_transportasi',
        'kode_prodi',
        'kode_pt_asal',
        'nama_pt_asal',
        'kode_prodi_asal',
        'nama_prodi_asal',
        'jenis_pembiayaan',
        'jumlah_biaya_masuk'
    ];


    public function model(array $row)
    {

        if (
            collect($row)->every(function ($value) {
                return is_null($value) || trim($value) === '';
            })
        ) {
            $this->rowNumber++;

            return null;
        }

        $tanggalLahir = $this->convertExcelDate($row['tanggal_lahir']);
        $tanggalMasukKuliah = $this->convertExcelDate($row['tanggal_masuk_kuliah']);

        $alamat =
            (!empty($row['jalan']) ? $row['jalan']. ',' : '') .
            (!empty($row['rt']) ? ' RT ' . $row['rt'] : '') .
            (!empty($row['rw']) ? ' RW ' . $row['rw'].',' : '') .
            (!empty($row['nama_dusun']) ? ' ' . $row['nama_dusun'].',' : '') .
            ' ' . $row['kelurahan'] . ' ' . $row['kecamatan'];

        foreach ($this->requiredFields as $field) {
            if (is_null($row[$field]) || $row[$field] === '') {
                $this->incompleteRecords[] =
                    "Baris ke {$this->rowNumber} tidak lengkap, kolom {$field} tidak boleh kosong <br>";
                $this->rowNumber++;
                return null;
            }
        }

        if (!Prodi::where('kode_prodi', $row['kode_prodi'])->exists()) {
            $this->incompleteRecords[] =
                "kode_prodi {$row['kode_prodi']} pada baris ke {$this->rowNumber} tidak terdaftar <br>";
            $this->rowNumber++;
            return null;
        }

        
        $idSemester = Semester::where('nama_semester', $row['mulai_semester'])->first()->id_semester;
        
        $existingUser = User::where('email', $row['email'])->first();
        
        if ($existingUser) {
            $this->incompleteRecords[] = "Email {$row['email']} pada baris {$this->rowNumber} sudah terdaftar pada user lain, Mahasiswa ini aka dibuat tanpa user.<br>";
        } else {
            $user = User::create([
                'name' => $row['nama'],
                'email' => $row['email'],
                'password' => Hash::make($row['email']),
                'nim_nidn' => $row['nim'],
                'role' => 'mahasiswa'
            ]);
            if ($this->isDuplicate($row['nim'], $row['nik'])) {
                $this->skippedRecords++;
                $this->rowNumber++;
                return null;
            } else {
                $this->createdRecords[] = "NIM = {$row['nim']} ,";
                $this->rowNumber++;
            }
        }
        $orangtua_wali = Orangtua_Wali::create([
            'nama_ayah' => $row['nama_ayah'],
            'NIK_ayah' => $row['nik_ayah'],
            'tanggal_lahir_ayah' => $row['tanggal_lahir_ayah'],
            'pendidikan_ayah' => $row['pendidikan_ayah'],
            'pekerjaan_ayah' => $row['pekerjaan_ayah'],
            'penghasilan_ayah' => $row['penghasilan_ayah'],
            'nama_ibu' => $row['nama_ibu'],
            'NIK_ibu' => $row['nik_ibu'],
            'tanggal_lahir_ibu' => $row['tanggal_lahir_ibu'],
            'pendidikan_ibu' => $row['pendidikan_ibu'],
            'pekerjaan_ibu' => $row['pekerjaan_ibu'],
            'penghasilan_ibu' => $row['penghasilan_ibu'],
            'nama_wali' => $row['nama_wali'] ?? null,
            'NIK_wali' => $row['nik_wali'] ?? null,
            'tanggal_lahir_wali' => $row['tanggal_lahir_wali'] ?? null,
            'pendidikan_wali' => $row['pendidikan_wali'] ?? null,
            'pekerjaan_wali' => $row['pekerjaan_wali'] ?? null,
            'penghasilan_wali' => $row['penghasilan_wali'] ?? null,
        ]);

        $mahasiswa = Mahasiswa::create([
            'id_orangtua_wali' => $orangtua_wali->id_orangtua_wali,
            'id_user' => $row['id'] ?? null,
            'NIM' => $row['nim'],
            'nama' => $row['nama'],
            'tempat_lahir' => $row['tempat_lahir'],
            'tanggal_lahir' => $tanggalLahir,
            'jenis_kelamin' => $row['jenis_kelamin'],
            'NIK' => $row['nik'],
            'agama' => $row['agama'],
            'alamat' => $alamat,
            'jalur_pendaftaran' => $row['jalur_pendaftaran'],
            'kewarganegaraan' => $row['kewarganegaraan'],
            'jenis_pendaftaran' => $row['jenis_pendaftaran'],
            'tanggal_masuk_kuliah' => $tanggalMasukKuliah,
            'mulai_semester' => $idSemester,
            'jenis_tempat_tinggal' => $row['jenis_tinggal'],
            'telp_rumah' => $row['telp_rumah'],
            'no_hp' => $row['no_hp'],
            'email' => $row['email'],
            'terima_kps' => $row['terima_kps'],
            'no_kps' => $row['no_kps'] ?? null,
            'jenis_transportasi' => $row['alat_transportasi'],
            'kode_prodi' => $row['kode_prodi'],
            'sks_diakui' => $row['sks_diakui'],
            'kode_pt_asal' => $row['kode_pt_asal'],
            'nama_pt_asal' => $row['nama_pt_asal'],
            'kode_prodi_asal' => $row['kode_prodi_asal'],
            'nama_prodi_asal' => $row['nama_prodi_asal'],
            'jenis_pembiayaan' => $row['jenis_pembiayaan'],
            'jumlah_biaya_masuk' => $row['jumlah_biaya_masuk'],
        ]);

        return $mahasiswa;
    }

    protected function isDuplicate($nim, $nik)
    {
        return Mahasiswa::where('NIM', $nim)->exists() || Mahasiswa::where('NIK', $nik)->exists();
    }

    protected function convertExcelDate($excelDate)
    {
        if (is_numeric($excelDate)) {
            $dateTime = Date::excelToDateTimeObject($excelDate);
            return Carbon::instance($dateTime)->format('Y-m-d');
        }

        try {
            return Carbon::createFromFormat('Y-m-d', trim($excelDate))->format('Y-m-d');
        } catch (\Exception $e) {
            \Log::error('Date conversion error: ' . $e->getMessage());
            return null;
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
