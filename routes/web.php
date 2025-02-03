<?php

use App\Http\Controllers\Controller;
use App\Models\Aktifitas;
use App\Models\Dosen;
use App\Models\Kelas;
use App\Models\KRS;
use App\Models\Mahasiswa;
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
    Route::get('/download/{no_kwitansi}', [App\Http\Controllers\PDFController::class, 'generatePDF'])->name('mahasiswa.download');
    Route::get('/krs', App\Livewire\Mahasiswa\Krs\Index::class)->name('mahasiswa.krs');
    Route::get('/emonev', App\Livewire\Mahasiswa\Emonev\Index::class)->name('mahasiswa.emonev');
    Route::get('/jadwal', App\Livewire\Mahasiswa\Jadwal\Index::class)->name('mahasiswa.jadwal');
    Route::get('/show/{id_kelas}', App\Livewire\Mahasiswa\Emonev\Show::class)->name('emonev.detail');
    Route::get('/khs/{NIM}', App\Livewire\Khs\Show::class)->name('mahasiswa.khs.show');
    Route::get('/keuangan/bayar/{order_id}', App\Livewire\Mahasiswa\Keuangan\Bayar::class)->name('mahasiswa.transaksi');
    Route::get('/keuangan/berhasil/{id_transaksi}', App\Livewire\Mahasiswa\Keuangan\Berhasil::class)->name('mahasiswa.transaksi.berhasil');
    Route::get('/keuangan/konfirmasi', App\Livewire\Mahasiswa\Keuangan\Konfirmasi::class)->name('mahasiswa.transaksi.konfirmasi');
    Route::get('/kartu_ujian', App\Livewire\Mahasiswa\KartuUjian\Index::class)->name('mahasiswa.ujian');

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
    Route::get('/tagihan/group-create', App\Livewire\Staff\Tagihan\GroupCreate::class)->name('staff.tagihan.group-create');
    Route::get('/pembayaran', App\Livewire\Staff\Tagihan\Show::class)->name('staff.pembayaran');
    Route::get('/detail/{NIM}', App\Livewire\Staff\Tagihan\Detail::class)->name('staff.detail');
    Route::get('/profil', App\Livewire\Staff\Profil\Index::class)->name('staff.profil');
    Route::get('/dashboard', App\Livewire\Staff\Dashboard\Index::class)->name('staff.dashboard');
    Route::get('/tagihan/transaksi', App\Livewire\Staff\Tagihan\Transaksi::class)->name('staff.tagihan.transaksi');
});



Route::get(
    '/test',
    function () {
        $namaAktifitasList = ['Tugas 1', 'Tugas 2', 'Tugas 3', 'Tugas 4', 'Tugas 5', 'UTS', 'UAS'];

        $kelasList = Kelas::all();


        foreach ($kelasList as $kelas) {
            foreach ($namaAktifitasList as $namaAktifitas) {
                $aktifitas = Aktifitas::updateOrCreate(
                    [
                        'nama_aktifitas' => $namaAktifitas,
                        'id_kelas' => $kelas->id_kelas,
                    ],
                    [
                        'catatan' => null,
                    ]
                );
                $mahasiswaList = Mahasiswa::whereIn('NIM', KRS::where('id_kelas', $kelas->id_kelas)->pluck('NIM'))->get();

                foreach ($mahasiswaList as $mahasiswa) {
                    Nilai::updateOrCreate(
                        [
                            'id_aktifitas' => $aktifitas->id_aktifitas,
                            'NIM' => $mahasiswa->NIM,
                            'id_kelas' => $kelas->id_kelas,
                        ],
                        [
                            'nilai' => rand(80, 100),
                        ]
                    );
                }
            }
        }
        dd('done');
    }
)->name('saddsa');

Route::get(
    '/tambah_ke_kelas',
    function () {
        $mahasiswaList = Mahasiswa::orderBy('NIM', 'desc')->get();
        $exceptions = ['9999999916', '99999999917', '9999999911', '9999999912', '9999999999', '9999999991', '9999999995', '9999999996'];

        foreach ($mahasiswaList as $mahasiswa) {
            $kelasA = Kelas::where('nama_kelas', 'a')
                ->where('kode_prodi', $mahasiswa->kode_prodi)
                ->first();
            $kelasB = Kelas::where('nama_kelas', 'b')
                ->where('kode_prodi', $mahasiswa->kode_prodi)
                ->first();

            if (in_array((string) $mahasiswa->NIM, array_map('strval', $exceptions))) {
                $mahasiswa->update(['id_kelas' => $kelasB->id_kelas]);
            } else {
                $countInKelasA = Mahasiswa::where('id_kelas', $kelasA->id_kelas)->count();

                if ($countInKelasA < 14) {
                    $mahasiswa->update(['id_kelas' => $kelasA->id_kelas]);
                } else {
                    $mahasiswa->update(['id_kelas' => $kelasB->id_kelas]);
                }
            }
        }

        dd($mahasiswaList->pluck('id_kelas'));

    }
)->name('adsaa');


