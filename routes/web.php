<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
route::get('/', App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard');

route::get('/login', App\Livewire\auth\Login::class)->name('login');
route::get('/register', App\Livewire\auth\Register::class)->name('register');
route::get('/forgot-password', App\Livewire\auth\ForgotPassword::class)->name('forgot-password');
Route::get('password/reset/{token}', App\Livewire\auth\ResetPassword::class)->name('password.reset');

// Auth::routes(['verify' => true]);

Route::prefix('mata_kuliah')->group(function () {
    Route::get('/', App\Livewire\Admin\Matkul\Index::class)->name('admin.mata_kuliah');
});

Route::prefix('prodi')->group(function () {
    Route::get('/', App\Livewire\Admin\Prodi\Index::class)->name('admin.prodi');
});

Route::prefix('dosen')->group(function () {
    Route::get('/', App\Livewire\Admin\Dosen\Index::class)->name('admin.dosen');
});

