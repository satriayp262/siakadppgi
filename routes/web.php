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

    Route::prefix('anggota')->group(function () {
        Route::get('/', App\Livewire\Admin\Anggota\Index::class)->name('admin.anggota');
        Route::get('/{nama_kelas}', App\Livewire\Admin\Anggota\Show::class)->name('admin.anggota.show');
        Route::get('/edit', App\Livewire\Admin\Anggota\Edit::class)->name('admin.anggota.edit');
    });

    Route::prefix('PaketKRS')->group(function () {
        Route::get('/', App\Livewire\Admin\paketKrs\Index::class)->name('admin.paketkrs');
        Route::get('/create', App\Livewire\Admin\paketKrs\Create::class)->name('admin.paketkrs.create');
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

    Route::prefix('ujian')->group(function () {
        Route::get('/', App\Livewire\Admin\JadwalUjian\Index::class)->name('admin.ujian');
    });

    Route::prefix('komponen_kartu_ujian')->group(function () {
        Route::get('/', App\Livewire\Admin\JadwalUjian\komponen::class)->name('admin.komponen_ujian');
    });

    Route::prefix('staff')->group(function () {
        Route::get('/', App\Livewire\Admin\Staff\Index::class)->name('admin.staff');
    });

    Route::prefix('presensiDosen')->group(function () {
        Route::get('/', App\Livewire\Admin\PresensiDosen\Index::class)->name('admin.presensiDosen');
        Route::get('/detail', App\Livewire\Admin\PresensiDosen\Detail::class)->name('admin.detailPresensiDosen');
    });

    Route::prefix('presensiMahasiswa')->group(function () {
        Route::get('/', App\Livewire\Admin\PresensiMahasiswa\Index::class)->name('admin.presensiMahasiswa');
    });
    Route::prefix('pertanyaan')->group(function () {
        Route::get('/', App\Livewire\Admin\Pertanyaan\Index::class)->name('admin.pertanyaan');
    });
    Route::prefix('emonev')->group(function () {
        Route::get('/', App\Livewire\Admin\Emonev\Index::class)->name('admin.emonev');
    });
    Route::prefix('emonev/periode')->group(function () {
        Route::get('/', App\Livewire\Admin\Periode\Index::class)->name('admin.emonev.periode');
    });
    Route::prefix('emonev/list-mahasiswa')->group(function () {
        Route::get('/', App\Livewire\Admin\Emonev\ListMahasiswa::class)->name('admin.emonev.list-mahasiswa');
    });
    Route::get('/khs', App\Livewire\Khs\Index::class)->name('dosen.khs');
    Route::get('/khs/detail/{NIM}', App\Livewire\Khs\Detail::class)->name('dosen.khs.detail');
    Route::get('/khs/download/{NIM}/{id_semester}', [App\Http\Controllers\KHSController::class, 'generatePDF'])->name('dosen.khs.download');
    Route::get('/khs/rekap/{NIM}', [App\Http\Controllers\KHSController::class, 'rekap'])->name('dosen.khs.rekap');
    Route::get('/khs/{nama_kelas}', App\Livewire\Khs\Show::class)->name('dosen.khs.show');

    Route::prefix('ttd')->group(function () {
        Route::get('/', App\Livewire\Admin\Ttd\Index::class)->name('admin.ttd');
    });
    Route::prefix('konversi')->group(function () {
        Route::get('/', App\Livewire\Admin\Konversi\Index::class)->name('admin.konversi');
    });
    Route::get('/download/konversi/{id}', function ($id) {
        $model = App\Models\KonversiNilai::findOrFail($id);
        $file = $model->file;
        $path = storage_path('app/public/' . $file);

        $nama = $model->krs->mahasiswa->nama ?? 'unknown';
        $keterangan = $model->keterangan ?? 'file';
        $filename = "konversi {$nama} ({$keterangan})." . pathinfo($file, PATHINFO_EXTENSION);

        return response()->download($path, $filename);
    })->name('konversi.download');
});

// mahasiswa
// Route::middleware(['auth', CheckRole::class . ':mahasiswa', 'verified'])
Route::middleware(['auth', CheckRole::class . ':mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/profil', App\Livewire\Mahasiswa\Profil\Index::class)->name('mahasiswa.profile');
    Route::get('/keuangan', App\Livewire\Mahasiswa\Keuangan\Index::class)->name('mahasiswa.keuangan');
    Route::get('/presensi', App\Livewire\Mahasiswa\Presensi\Index::class)->name('mahasiswa.presensi');
    Route::get('/download/{no_kwitansi}', [App\Http\Controllers\PDFController::class, 'generatePDF'])->name('mahasiswa.download');
    Route::get('/krs', App\Livewire\Mahasiswa\Krs\Index::class)->name('mahasiswa.krs');
    Route::get('/emonev', App\Livewire\Mahasiswa\Emonev\Index::class)->name('mahasiswa.emonev');
    Route::get('/jadwal', App\Livewire\Mahasiswa\Jadwal\Index::class)->name('mahasiswa.jadwal');
    Route::get('/emonev/{nama_semester}/{id_mata_kuliah}', App\Livewire\Mahasiswa\Emonev\Show::class)->name('emonev.detail');
    Route::get('/khs/detail/{NIM}', App\Livewire\Khs\Detail::class)->name('mahasiswa.khs.detail');
    Route::get('/khs/download/{NIM}/{id_semester}', [App\Http\Controllers\KHSController::class, 'generatePDF'])->name('mahasiswa.khs.download');
    Route::get('/khs/rekap/{NIM}', [App\Http\Controllers\KHSController::class, 'rekap'])->name('mahasiswa.khs.rekap');
    Route::get('/keuangan/bayar/{order_id}', App\Livewire\Mahasiswa\Keuangan\Bayar::class)->name('mahasiswa.transaksi');
    Route::get('/keuangan/cicilan/{id_tagihan}', App\Livewire\Mahasiswa\Keuangan\Cicil::class)->name('mahasiswa.transaksi.cicilan');
    Route::get('/keuangan/berhasil/{id_transaksi}', App\Livewire\Mahasiswa\Keuangan\Berhasil::class)->name('mahasiswa.transaksi.berhasil');
    Route::get('/keuangan/konfirmasi', App\Livewire\Mahasiswa\Keuangan\Konfirmasi::class)->name('mahasiswa.transaksi.konfirmasi');
    Route::get('/keuangan/histori', App\Livewire\Mahasiswa\Keuangan\Histori::class)->name('mahasiswa.transaksi.histori');
    Route::get('/kartu_ujian', App\Livewire\Mahasiswa\KartuUjian\Index::class)->name('mahasiswa.ujian');
    Route::get('/PaketKRS', App\Livewire\Mahasiswa\paketKrs\Index::class)->name('mahasiswa.paketkrs');
});

// dosen
// Route::middleware(['auth', CheckRole::class . ':dosen', 'verified'])

Route::middleware(['auth', CheckRole::class . ':dosen'])->prefix('dosen')->group(function () {
    Route::get('/Dashboard', App\Livewire\Dosen\Home\Dashboard::class)->name('dosen.dashboard');
    Route::get('/jadwal', App\Livewire\Dosen\Jadwal\Index::class)->name('dosen.jadwal');
    Route::get('/berita_acara', App\Livewire\Dosen\BeritaAcara\Index::class)->name('dosen.berita_acara');
    Route::get('/input_nilai', App\Livewire\Dosen\InputNilai\Index::class)->name('dosen.input_nilai');

    Route::prefix('aktifitas')->group(function () {
        Route::get('/', App\Livewire\Dosen\Aktifitas\Index::class)->name('dosen.aktifitas');
        Route::get('/{kode_mata_kuliah}', App\Livewire\Dosen\Aktifitas\Kelas\Index::class)->name('dosen.aktifitas.kelas');
        Route::get('/{kode_mata_kuliah}/{nama_kelas}', App\Livewire\Dosen\Aktifitas\Kelas\Show::class)->name('dosen.aktifitas.kelas.show');
        Route::get('/{kode_mata_kuliah}/{nama_kelas}/{nama_aktifitas}', App\Livewire\Dosen\Aktifitas\Kelas\Aktifitas\Index::class)->name('dosen.aktifitas.kelas.aktifitas');
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
    Route::get('/rekap_presensi/{id_mata_kuliah}/{id_kelas}', App\Livewire\Dosen\Presensi\RekapPresensi::class)->name('dosen.rekap_presensi');

    Route::get('/emonev', App\Livewire\Dosen\Emonev\Index::class)->name('dosen.emonev');
    Route::get('/emonev/show/{kode}', App\Livewire\Dosen\Emonev\Show::class)->name('dosen.emonev.show');
});

// staff
Route::middleware(['auth', CheckRole::class . ':staff'])->prefix('staff')->group(function () {
    Route::get('/tagihan', App\Livewire\Staff\Tagihan\Index::class)->name('staff.tagihan');
    Route::get('/tagihan/group-create', App\Livewire\Staff\Tagihan\GroupCreate::class)->name('staff.tagihan.group-create');
    Route::get('/pembayaran', App\Livewire\Staff\Tagihan\Show::class)->name('staff.pembayaran');
    Route::get('/detail/{NIM}', App\Livewire\Staff\Tagihan\Detail::class)->name('staff.detail');
    Route::get('/profil', App\Livewire\Staff\Profil\Index::class)->name('staff.profil');
    Route::get('/konfirmasi', App\Livewire\Staff\Konfirmasi\Index::class)->name('staff.konfirmasi');
    Route::get('/dashboard', App\Livewire\Staff\Dashboard\Index::class)->name('staff.dashboard');
    Route::get('/tagihan/multiple-create', App\Livewire\Staff\Tagihan\MultipleCreate::class)->name('staff.tagihan.multiple-create');
    Route::get('/tagihan/update/{id_tagihan}', App\Livewire\Staff\Tagihan\Update::class)->name('staff.tagihan.update');
});
