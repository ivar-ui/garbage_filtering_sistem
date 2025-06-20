<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WasteDataController;
use App\Http\Controllers\ExportController;

// Halaman utama (grafik + data terbaru)
Route::get('/', [WasteDataController::class, 'index'])->name('home');

// Simpan data dari sensor (POST)
Route::post('/waste_data', [WasteDataController::class, 'store'])->name('waste.store');

// Halaman Data Sampah (landing)
Route::get('/data-sampah', [WasteDataController::class, 'index'])->name('data.sampah');

// Halaman Detail Sampah (semua data)
Route::get('/detail-sampah', [WasteDataController::class, 'detail'])->name('detail.sampah');

// Halaman Riwayat Sensor (riwayat lengkap)
Route::get('/riwayat-sensor', [WasteDataController::class, 'riwayat'])->name('riwayat.sensor');

// API untuk ambil data terbaru (digunakan AJAX)
Route::get('/api/waste-latest', [WasteDataController::class, 'getLatest'])->name('waste.latest');

// Unduh data ke Excel
Route::get('/export-excel', [ExportController::class, 'export'])->name('export.excel');
