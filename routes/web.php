<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\SiswaController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('admin', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/register', function () {
    abort(404);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::resource('peminjam', PeminjamController::class);
Route::resource('siswa', SiswaController::class);
Route::resource('barang', BarangController::class);

