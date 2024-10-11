<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Livewire\Auth\VerifyEmail;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckRole;

// auth
Route::get('/', App\Livewire\Auth\Login::class)->name('login');
Route::get('/register', App\Livewire\Auth\Register::class)->name('register');
Route::get('/forgot-password', App\Livewire\Auth\ForgotPassword::class)->name('forgot-password');
Route::get('password/reset/{token}', App\Livewire\Auth\ResetPassword::class)->name('password.reset');

Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', VerifyEmail::class)->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard'); // Change this to the desired post-verification route
    })->middleware(['signed'])->name('verification.verify');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/');
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

    Route::get('/mahasiswa', App\Livewire\Admin\Mahasiswa\Index::class)->name('admin.mahasiswa');

    Route::prefix('prodi')->group(function () {
        Route::get('/', App\Livewire\Admin\Prodi\Index::class)->name('admin.prodi');
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
});

// mahasiswa
Route::middleware(['auth', CheckRole::class . ':mahasiswa'])->prefix('mahasiswa')->group(function () {
    Route::get('/profil', App\Livewire\Mahasiswa\Profil\Index::class)->name('mahasiswa.profile');
    Route::get('/keuangan', App\Livewire\Mahasiswa\Keuangan\Index::class)->name('mahasiswa.keuangan');
    Route::get('/presensi', App\Livewire\Mahasiswa\Presensi\Index::class)->name('mahasiswa.presensi');
});

// dosen
Route::middleware(['auth', CheckRole::class . ':dosen'])->prefix('dosen')->group(function () {
    Route::get('/jadwal', App\Livewire\Dosen\Jadwal\Index::class)->name('dosen.jadwal');
    Route::get('/berita_acara', App\Livewire\Dosen\BeritaAcara\Index::class)->name('dosen.berita_acara');
    Route::get('/presensi', App\Livewire\Dosen\Presensi\Index::class)->name('dosen.presensi');
});

// staff
Route::middleware(['auth', CheckRole::class . ':staff'])->prefix('staff')->group(function () {
    Route::get('/tagihan', App\Livewire\Staff\Tagihan\Index::class)->name('staff.tagihan');
});

// Auth::routes(['verify' => true]);

