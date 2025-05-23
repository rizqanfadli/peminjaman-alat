<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [FormController::class, 'index'])->name('home');

Route::get('admin', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('/register', function () {
    abort(404);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

Route::resource('peminjam', PeminjamController::class);
Route::resource('siswa', SiswaController::class);
Route::resource('barang', BarangController::class);
Route::resource('form', FormController::class);

// API untuk dropdown
Route::get('/api/siswa', fn() => \App\Models\DataSiswa::all())->name('api.siswa');
Route::get('/api/barang', fn() => \App\Models\DataBarang::all())->name('api.barang');

Route::get('/data_siswa', function () {
    return response()->json(['success' => true]);
});
Route::patch('peminjam/{peminjam}/update-status', [PeminjamController::class, 'updateStatus'])->name('peminjam.updateStatus');
