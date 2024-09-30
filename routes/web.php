<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Livewire\Auth\VerifyEmail;
use Illuminate\Support\Facades\Auth;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', VerifyEmail::class)->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard'); // Change this to the desired post-verification route
    })->middleware(['auth', 'signed'])->name('verification.verify');
});


// admin
Route::middleware(['auth'])->group(function () {
    // Route::middleware(['auth', 'verified'])->group(function () {
    route::prefix('admin')->group(function () {

        Route::get('/dashboard', App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard');
        Route::prefix('mata_kuliah')->group(function () {
            Route::get('/', App\Livewire\Admin\Matkul\Index::class)->name('admin.mata_kuliah');
        });

        route::get('/mahasiswa', App\Livewire\Admin\Mahasiswa\Index::class)->name('admin.mahasiswa');
        Route::prefix('prodi')->group(function () {
            Route::get('/', App\Livewire\Admin\Prodi\Index::class)->name('admin.prodi');
        });

        Route::prefix('kelas')->group(function () {
            Route::get('/', App\Livewire\Admin\Kelas\Index::class)->name('admin.kelas');
        });

        Route::prefix('dosen')->group(function () {
            Route::get('/', App\Livewire\Admin\Dosen\Index::class)->name('admin.dosen');
        });

        Route::prefix('user')->group(function () {
            Route::get('/', App\Livewire\Admin\User\Index::class)->name('admin.user');
        });
    });
});

Route::middleware(['auth'])->group(function () {

    Route::prefix('mahasiswa')->group(function () {
        route::get('/profil', App\Livewire\Mahasiswa\Profil\Index::class)->name('mahasiswa.profile');
    });
});



route::get('/', App\Livewire\auth\Login::class)->name('login');


// Sementara Logout e kaya kiye ya wkwk, males gawe livewire e
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

route::get('/register', App\Livewire\auth\Register::class)->name('register');
route::get('/forgot-password', App\Livewire\auth\ForgotPassword::class)->name('forgot-password');
Route::get('password/reset/{token}', App\Livewire\auth\ResetPassword::class)->name('password.reset');




// Auth::routes(['verify' => true]);
