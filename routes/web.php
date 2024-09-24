<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
route::get('/admin', App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard');


Route::prefix('mata_kuliah')->group(function () {
    Route::get('/', App\Livewire\Admin\Matkul\Index::class)->name('admin.mata_kuliah');
});