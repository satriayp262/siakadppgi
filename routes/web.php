<?php

use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\Nilai;
use App\Models\Prodi;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Livewire\Auth\VerifyEmail;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckRole;


// auth
Route::get('/', App\Livewire\LandingPage::class)->name('landing');
Route::get('/login', App\Livewire\Auth\Login::class)->name('login');
Route::get('/register', App\Livewire\Auth\Register::class)->name('register');
Route::get('/forgot-password', App\Livewire\Auth\ForgotPassword::class)->name('forgot-password');
Route::get('password/reset/{token}', App\Livewire\Auth\ResetPassword::class)->name('password.reset');

Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', VerifyEmail::class)->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect()->intended();
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login');
    })->name('logout');
});

// admin
Route::middleware(['auth', CheckRole::class . ':admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard');

    Route::prefix('profil')->group(function () {
        Route::get('/', App\Livewire\Mahasiswa\Profil\Index::class)->name('mahasiswa.profil');
    });

    Route::prefix('mata_kuliah')->group(function () {
        Route::get('/', App\Livewire\Admin\Matkul\Index::class)->name('admin.mata_kuliah');
    });
    Route::prefix('ruangan')->group(function () {
        Route::get('/', App\Livewire\Admin\Ruangan\Index::class)->name('admin.ruangan');
    });
    Route::prefix('krs')->group(function () {
        Route::get('/', App\Livewire\Admin\Krs\Index::class)->name('admin.krs');
        Route::get('/{NIM}', App\Livewire\Admin\Krs\Mahasiswa\Index::class)->name('admin.krs.mahasiswa');
        Route::get('/{NIM}/{semester}', App\Livewire\Admin\Krs\Mahasiswa\Edit::class)->name('admin.krs.edit');
    });

    Route::get('/mahasiswa', App\Livewire\Admin\Mahasiswa\Index::class)->name('admin.mahasiswa');
    Route::get('/pengumuman', App\Livewire\Admin\Pengumuman\Index::class)->name('admin.pengumuman');

    Route::prefix('prodi')->group(function () {
        Route::get('/', App\Livewire\Admin\Prodi\Index::class)->name('admin.prodi');
    });

    Route::prefix('kurikulum')->group(function () {
        Route::get('/', App\Livewire\Admin\Kurikulum\Index::class)->name('admin.kurikulum');
    });

    Route::prefix('kelas')->group(function () {
        Route::get('/', App\Livewire\Admin\Kelas\Index::class)->name('admin.kelas');
    });

    Route::prefix('dosen')->group(function () {
        Route::get('/', App\Livewire\Admin\Dosen\Index::class)->name('admin.dosen');
    });

    Route::prefix('semester')->group(function () {
        Route::get('/', App\Livewire\Admin\Semester\Index::class)->name('admin.semester');
    });

    Route::prefix('user')->group(function () {
        Route::get('/', App\Livewire\Admin\User\Index::class)->name('admin.user');
    });

    Route::prefix('jadwal')->group(function () {
        Route::get('/', App\Livewire\Admin\Jadwal\Index::class)->name('admin.jadwal');
    });

    Route::prefix('staff')->group(function () {
        Route::get('/', App\Livewire\Admin\Staff\Index::class)->name('admin.staff');
    });

    Route::prefix('presensiDosen')->group(function () {
        Route::get('/', App\Livewire\Admin\PresensiDosen\Index::class)->name('admin.presensiDosen');
    });

    Route::prefix('presensiMahasiswa')->group(function () {
        Route::get('/', App\Livewire\Admin\PresensiMahasiswa\Index::class)->name('admin.presensiMahasiswa');
    });
    Route::prefix('pertanyaan')->group(function () {
        Route::get('/', App\Livewire\Admin\Pertanyaan\Index::class)->name('admin.pertanyaan');
    });
});

// mahasiswa
Route::middleware(['auth', CheckRole::class . ':mahasiswa', 'verified'])->prefix('mahasiswa')->group(function () {
    Route::get('/profil', App\Livewire\Mahasiswa\Profil\Index::class)->name('mahasiswa.profile');
    Route::get('/keuangan', App\Livewire\Mahasiswa\Keuangan\Index::class)->name('mahasiswa.keuangan');
    Route::get('/presensi', App\Livewire\Mahasiswa\Presensi\Index::class)->name('mahasiswa.presensi');
    Route::get('/download/{id_tagihan}', [App\Http\Controllers\PDFController::class, 'generatePDF'])->name('mahasiswa.download');
    Route::get('/krs', App\Livewire\Mahasiswa\Krs\Index::class)->name('mahasiswa.krs');
    Route::get('/jadwal', App\Livewire\Mahasiswa\Jadwal\Index::class)->name('mahasiswa.jadwal');
});

// dosen
Route::middleware(['auth', CheckRole::class . ':dosen', 'verified'])->prefix('dosen')->group(function () {
    Route::get('/Dashboard', App\Livewire\Dosen\Home\Dashboard::class)->name('dosen.dashboard');
    Route::get('/jadwal', App\Livewire\Dosen\Jadwal\Index::class)->name('dosen.jadwal');
    Route::get('/berita_acara', App\Livewire\Dosen\BeritaAcara\Index::class)->name('dosen.berita_acara');
    Route::get('/input_nilai', App\Livewire\Dosen\InputNilai\Index::class)->name('dosen.input_nilai');

    Route::prefix('aktifitas')->group(function () {
        Route::get('/', App\Livewire\Dosen\Aktifitas\Index::class)->name('dosen.aktifitas');
        Route::get('/{kode_mata_kuliah}', App\Livewire\Dosen\Aktifitas\Kelas\Index::class)->name('dosen.aktifitas.kelas');
        Route::get('/{kode_mata_kuliah}/{id_kelas}', App\Livewire\Dosen\Aktifitas\Kelas\Show::class)->name('dosen.aktifitas.kelas.show');
        Route::get('/{kode_mata_kuliah}/{id_kelas}/{nama_aktifitas}', App\Livewire\Dosen\Aktifitas\Kelas\Aktifitas\Index::class)->name('dosen.aktifitas.kelas.aktifitas');
        // Route::get('/{NIM}/{semester}', App\Livewire\Admin\Krs\Mahasiswa\Edit::class)->name('admin.krs.edit');
    });
    Route::prefix('bobot')->group(function () {
        Route::get('/', App\Livewire\Dosen\Bobot\Index::class)->name('dosen.bobot');
        Route::get('/{kode_mata_kuliah}', App\Livewire\Dosen\Bobot\Kelas\Index::class)->name('dosen.bobot.kelas');
    });
    Route::get('/berita_acara/detail_matkul{id_mata_kuliah}', \App\Livewire\Dosen\BeritaAcara\DetailMatkul::class)->name('dosen.berita_acara.detail_matkul');
    Route::get('/berita_acara/detail_matkul{id_mata_kuliah}/detail_kelas{id_kelas}', \App\Livewire\Dosen\BeritaAcara\DetailKelas::class)->name('dosen.berita_acara.detail_kelas');

    Route::get('/presensi', App\Livewire\Dosen\Presensi\Index::class)->name('dosen.presensi');
    Route::get('/presensi/detail_presensi{id_mata_kuliah}', App\Livewire\Dosen\Presensi\AbsensiByKelas::class)->name('dosen.presensiByKelas');
    Route::get('/presensi/detail_presensi{id_mata_kuliah}/detail_kelas{id_kelas}', App\Livewire\Dosen\Presensi\AbsensiByToken::class)->name('dosen.presensiByToken');
    Route::get('/detail_presensi/{token}', App\Livewire\Dosen\Presensi\DetailPresensi::class)->name('dosen.detail_presensi');

    Route::get('/khs', App\Livewire\Khs\Index::class)->name('dosen.khs');
    Route::get('/khs/{NIM}', App\Livewire\Khs\Show::class)->name('dosen.khs.show');
});

// staff
Route::middleware(['auth', CheckRole::class . ':staff'])->prefix('staff')->group(function () {
    Route::get('/tagihan', App\Livewire\Staff\Tagihan\Index::class)->name('staff.tagihan');
    Route::get('/pembayaran', App\Livewire\Staff\Tagihan\Show::class)->name('staff.pembayaran');
    Route::get('/detail/{NIM}', App\Livewire\Staff\Tagihan\Detail::class)->name('staff.detail');
    Route::get('/profil', App\Livewire\Staff\Profil\Index::class)->name('staff.profil');
    Route::get('/dashboard', App\Livewire\Staff\Dashboard\Index::class)->name('staff.dashboard');
});



Route::get(
    '/test',
    function () {
        $kelas = Kelas::find(17);
        $NIM = 9999999998;

        if (!$kelas) {
            throw new \Exception('Kelas not found for the given KHS.');
        }

        // Retrieve bobot percentages from `kelas`
        $bobotTugas = $kelas->tugas ?? 0;
        $bobotUTS = $kelas->uts ?? 0;
        $bobotUAS = $kelas->uas ?? 0;
        $bobotLainnya = $kelas->lainnya ?? 0;

        // Calculate total weight
        $totalWeight = $bobotTugas + $bobotUTS + $bobotUAS + $bobotLainnya;

        // Normalize weights if the total weight is not 100
        if ($totalWeight != 100) {
            $bobotTugas = ($bobotTugas / $totalWeight) * 100;
            $bobotUTS = ($bobotUTS / $totalWeight) * 100;
            $bobotUAS = ($bobotUAS / $totalWeight) * 100;
            $bobotLainnya = ($bobotLainnya / $totalWeight) * 100;
        }

        // Initialize total bobot
        $totalBobot = 0;

        // Calculate bobot for UTS
        $nilaiUTS = Nilai::where('NIM', $NIM)
            ->where('id_kelas', $kelas->id_kelas)
            ->whereHas('aktifitas', function ($query) {
            $query->where('nama_aktifitas', 'UTS');
        })
            ->first();

        if ($nilaiUTS) {
            $totalBobot += ($nilaiUTS->nilai / 100) * 4.00 * ($bobotUTS / 100);
        }

        // Calculate bobot for UAS
        $nilaiUAS = Nilai::where('NIM', $NIM)
            ->where('id_kelas', $kelas->id_kelas)
            ->whereHas('aktifitas', function ($query) {
            $query->where('nama_aktifitas', 'UAS');
        })
            ->first();

        if ($nilaiUAS) {
            $totalBobot += ($nilaiUAS->nilai / 100) * 4.00 * ($bobotUAS / 100);
        }

        // Calculate bobot for Lainnya
        $nilaiLainnya = Nilai::where('NIM', $NIM)
            ->where('id_kelas', $kelas->id_kelas)
            ->whereHas('aktifitas', function ($query) {
            $query->where('nama_aktifitas', 'Lainnya');
        })
            ->first();

        if ($nilaiLainnya) {
            $totalBobot += ($nilaiLainnya->nilai / 100) * 4.00 * ($bobotLainnya / 100);
        }

        // Calculate bobot for Tugas (all other activities)
        $nilaiTugas = Nilai::where('NIM', $NIM)
            ->where('id_kelas', $kelas->id_kelas)
            ->whereHas('aktifitas', function ($query) {
            $query->whereNotIn('nama_aktifitas', ['UTS', 'UAS', 'Lainnya']);
        })
            ->get();

        if ($nilaiTugas->isNotEmpty()) {
            // Calculate the average nilai for Tugas
            $averageTugas = $nilaiTugas->avg('nilai');

            // Convert to a 4.00 scale
            $averageTugasScaled = ($averageTugas / 100) * 4.00;

            // Add the weighted Tugas score to the total bobot
            $totalBobot += $averageTugasScaled * ($bobotTugas / 100);
        }

        // Ensure the totalBobot does not exceed 4.00
        $this->bobot = round($totalBobot,2);
dd($this->bobot);
        // $this->save();

    }
)->name('saddsa');



