<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
route::get('/admin', App\Livewire\Admin\Dashboard\Index::class)->name('admin.dashboard');
