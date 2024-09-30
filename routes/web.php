<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Livewire\Auth\VerifyEmail;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckRole;

// auth
route::get('/', App\Livewire\auth\Login::class)->name('login');
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', VerifyEmail::class)->name('verification.notice');

    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/dashboard'); // Change this to the desired post-verification route
    })->middleware(['auth', 'signed'])->name('verification.verify');
});
route::get('/register', App\Livewire\auth\Register::class)->name('register');
route::get('/forgot-password', App\Livewire\auth\ForgotPassword::class)->name('forgot-password');
Route::get('password/reset/{token}', App\Livewire\auth\ResetPassword::class)->name('password.reset');



// admin
Route::middleware(['auth', CheckRole::class . ':admin'] )->group(function () {
    // Route::middleware(['auth', 'verified' ,CheckRole::class . ':admin'])->group(function () {
    route::prefix('admin')->group(function () {

        Route::get('/dashboard', App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard');
    
    Route::prefix('profil')->group(function () {
        Route::get('/', App\Livewire\Mahasiswa\Profil\Index::class)->name('mahasiswa.profil');
    });

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



// mahasiswa
Route::middleware(['auth', CheckRole::class . ':mahasiswa'])->group(function () {

    Route::prefix('mahasiswa')->group(function () {
        route::get('/profil', App\Livewire\Mahasiswa\Profil\Index::class)->name('mahasiswa.profile');
    });
});


// logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');

route::get('/register', App\Livewire\auth\Register::class)->name('register');
route::get('/forgot-password', App\Livewire\auth\ForgotPassword::class)->name('forgot-password');
Route::get('password/reset/{token}', App\Livewire\auth\ResetPassword::class)->name('password.reset');



// admin
Route::middleware(['auth', CheckRole::class . ':admin'] )->group(function () {
    // Route::middleware(['auth', 'verified' ,CheckRole::class . ':admin'])->group(function () {
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



// mahasiswa
Route::middleware(['auth', CheckRole::class . ':mahasiswa'])->group(function () {

    Route::prefix('mahasiswa')->group(function () {
        route::get('/profil', App\Livewire\Mahasiswa\Profil\Index::class)->name('mahasiswa.profile');
    });
});


// logout
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');





// Auth::routes(['verify' => true]);
