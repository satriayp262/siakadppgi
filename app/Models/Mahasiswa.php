<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;





class Mahasiswa extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_mahasiswa';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $table = 'mahasiswa';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Str::uuid();
        });
    }
    protected $fillable = [
        'id_mahasiswa',
        'id_orangtua_wali',
        'NIM',
        'NISN',
        'NPWP',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'NIK',
        'agama',
        'alamat',
        'jalur_pendaftaran',
        'kewarganegaraan',
        'jenis_pendaftaran',
        'tanggal_masuk_kuliah',
        'mulai_semester',
        'jenis_tempat_tinggal',
        'telp_rumah',
        'no_hp',
        'email',
        'terima_kps',
        'no_kps',
        'jenis_transportasi',
        'kode_prodi',
        'SKS_diakui',
        'kode_pt_asal',
        'nama_pt_asal',
        'kode_prodi_asal',
        'nama_prodi_asal',
        'jenis_pembiayaan',
        'jumlah_biaya_masuk',
        'id_kelas',
    ];


    public function orangtuaWali()
    {
        return $this->belongsTo(Orangtua_Wali::class, 'id_orangtua_wali', 'id_orangtua_wali');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'mulai_semester', 'id_semester');
    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id_kelas');
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'NIM', 'NIM');
    }
    public function getSemesterDifferenceAttribute()
    {
        // Retrieve the latest semester information
        $latestSemester = Semester::firstWhere('is_active', true);
        if (!$latestSemester) {
            return null; // Handle case when there are no semesters
        }
        $latestSemesterYear = (int) substr($latestSemester->nama_semester, 0, 4);
        $latestSemesterDigit5 = (int) substr($latestSemester->nama_semester, 4, 1);

        // Get the initial semester for this mahasiswa
        $initialSemester = (int) substr($this->semester->nama_semester ?? '0000', 0, 4);
        $initialSemesterDigit5 = (int) substr($this->semester->nama_semester ?? '00000', 4, 1);

        // Calculate the semester difference
        $semesterDifference = ($latestSemesterYear - $initialSemester) * 2;

        // Adjust based on the fifth digit
        if ($latestSemesterDigit5 == $initialSemesterDigit5) {
            $semesterDifference += 1;
        } elseif ($latestSemesterDigit5 > $initialSemesterDigit5) {
            $semesterDifference += 2;
        }

        return $semesterDifference;
    }

    public function getSemester($id_semester)
    {
        // Retrieve the chosen semester based on the provided ID
        $semester = Semester::find($id_semester);

        if (!$semester) {
            return null; // Handle case when the semester is not found
        }

        $chosenSemesterYear = (int) substr($semester->nama_semester, 0, 4);
        $chosenSemesterDigit5 = (int) substr($semester->nama_semester, 4, 1);

        // Get the initial semester for this mahasiswa
        $initialSemesterYear = (int) substr($this->semester->nama_semester ?? '0000', 0, 4);
        $initialSemesterDigit5 = (int) substr($this->semester->nama_semester ?? '00000', 4, 1);

        // Calculate the semester difference
        $semesterDifference = ($chosenSemesterYear - $initialSemesterYear) * 2;

        // Adjust based on the fifth digit
        if ($chosenSemesterDigit5 == $initialSemesterDigit5) {
            $semesterDifference += 1;
        } elseif ($chosenSemesterDigit5 > $initialSemesterDigit5) {
            $semesterDifference += 2;
        }

        return $semesterDifference;
    }



    private static $jenisKelaminOptions = [
        'L' => 'Laki-laki',
        'P' => 'Perempuan',
    ];

    private static $agamaOptions = [
        1 => 'Islam',
        2 => 'Kristen',
        3 => 'Katolik',
        4 => 'Hindu',
        5 => 'Buddha',
        6 => 'Konghucu',
        99 => 'Lainnya',
    ];

    private static $jalurPendaftaranOptions = [
        3 => 'Penelusuran Minat dan Kemampuan (PMDK)',
        4 => 'Prestasi',
        9 => 'Program Internasional',
        11 => 'Program Kerjasama Perusahaan/Institusi/Pemerintah',
        12 => 'Seleksi Mandiri',
        13 => 'Ujian Masuk Bersama Lainnya',
        14 => 'Seleksi Nasional Berdasarkan Tes (SNBT)',
        15 => 'Seleksi Nasional Berdasarkan Prestasi (SNBP)',
    ];

    private static $jenisPendaftaranOptions = [
        1 => 'Peserta didik baru',
        2 => 'Pindahan',
        3 => 'Naik Kelas',
        4 => 'Akselerasi',
        5 => 'Mengulang',
        6 => 'Lanjutan semester',
        8 => 'Pindahan Alih Bentuk',
        13 => 'RPL Perolehan SKS',
        14 => 'Pendidikan Non Gelar (Course)',
        15 => 'Fast Track',
        16 => 'RPL Transfer SKS',
    ];

    private static $jenisTempatTinggalOptions = [
        1 => 'Bersama orang tua',
        2 => 'Wali',
        3 => 'Kost',
        4 => 'Asrama',
        5 => 'Panti asuhan',
        10 => 'Rumah sendiri',
        99 => 'Lainnya',
    ];

    private static $jenisTransportasiOptions = [
        1 => 'Jalan kaki',
        3 => 'Angkutan umum/bus/pete-pete',
        4 => 'Mobil/bus antar jemput',
        5 => 'Kereta api',
        6 => 'Ojek',
        7 => 'Andong/bendi/sado/dokar/delman/becak',
        8 => 'Perahu penyeberangan/rakit/getek',
        11 => 'Kuda',
        12 => 'Sepeda',
        13 => 'Sepeda motor',
        14 => 'Mobil pribadi',
        99 => 'Lainnya',
    ];

    private static $jenisPembiayaanOptions = [
        1 => 'Mandiri',
        2 => 'Beasiswa Tidak Penuh',
        3 => 'Beasiswa Penuh',
    ];


    public function getJenisKelamin()
    {
        if ($this->attributes['jenis_kelamin'] == null) {
            return 'Data belum ada';
        }
        return self::$jenisKelaminOptions[$this->attributes['jenis_kelamin']] ?? 'Data Invalid';
    }

    public function getAgama()
    {
        if ($this->attributes['agama'] == null) {
            return 'Data belum ada';
        }
        return self::$agamaOptions[$this->attributes['agama']] ?? 'Data Invalid';
    }

    public function getJalurPendaftaran()
    {
        if ($this->attributes['jalur_pendaftaran'] == null) {
            return 'Data belum ada';
        }
        return self::$jalurPendaftaranOptions[$this->attributes['jalur_pendaftaran']] ?? 'Data Invalid';
    }

    public function getJenisPendaftaran()
    {
        if ($this->attributes['jenis_pendaftaran'] == null) {
            return 'Data belum ada';
        }
        return self::$jenisPendaftaranOptions[$this->attributes['jenis_pendaftaran']] ?? 'Data Invalid';
    }

    public function getJenisTempatTinggal()
    {
        if ($this->attributes['jenis_tempat_tinggal'] == null) {
            return 'Data belum ada';
        }
        return self::$jenisTempatTinggalOptions[$this->attributes['jenis_tempat_tinggal']] ?? 'Data Invalid';
    }

    public function getJenisTransportasi()
    {
        if ($this->attributes['jenis_transportasi'] == null) {
            return 'Data belum ada';
        }
        return self::$jenisTransportasiOptions[$this->attributes['jenis_transportasi']] ?? 'Data Invalid';
    }

    public function getJenisPembiayaan()
    {
        if ($this->attributes['jenis_pembiayaan'] == null) {
            return 'Data belum ada';
        }
        return self::$jenisPembiayaanOptions[$this->attributes['jenis_pembiayaan']] ?? 'Data Invalid';
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'nim', 'nim');
    }

    public function token()
    {
        return $this->hasManyThrough(Token::class, Presensi::class, 'nim', 'token', 'nim', 'token');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'nim_nidn', 'NIM');
    }
}
