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
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'kode_prodi', 'kode_prodi');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'mulai_semester', 'id_semester');
    }

    public function tagihan()
    {
        return $this->hasMany(Tagihan::class, 'nim', 'nim');
    }
    public function getSemesterDifferenceAttribute()
    {
        // Retrieve the latest semester information
        $latestSemester = Semester::orderBy('nama_semester', 'desc')->first();
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
}
