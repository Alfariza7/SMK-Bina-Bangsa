<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Kepsek\KepsekDashboardController;
use App\Http\Controllers\Teller\TellerDashboardController;
use App\Http\Controllers\Siswa\SiswaDashboardController;
use App\Http\Controllers\PaymentGatewayController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\KuitansiController;
use Illuminate\Support\Facades\Route;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Autentikasi Pengguna
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Group Role: ADMIN
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
});

// Group Role: KEPALA SEKOLAH
Route::middleware(['auth', 'role:kepala_sekolah'])->prefix('kepsek')->name('kepsek.')->group(function () {
    Route::get('/dashboard', [KepsekDashboardController::class, 'index'])->name('dashboard');
});

// Group Role: TELLER
Route::middleware(['auth', 'role:teller'])->prefix('teller')->name('teller.')->group(function () {
    Route::get('/dashboard', [TellerDashboardController::class, 'index'])->name('dashboard');
});

// Group Role: SISWA
Route::middleware(['auth', 'role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');
});

// Modul Laporan & Cetak Rekapitulasi (Admin, Teller, Kepala Sekolah)
Route::middleware(['auth', 'role:admin,teller,kepala_sekolah'])->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
});

// Modul Kuitansi Pembayaran Digital (Diakses Siswa pemilik transaksi atau Admin/Teller/Kepsek)
Route::middleware(['auth'])->group(function () {
    Route::get('/transaksi/{id}/kuitansi', [KuitansiController::class, 'show'])->name('transaksi.kuitansi');
});

// Simulasi Payment Gateway & Callback Webhook (Poin G, H, I Dokumen Soal)
Route::get('/simulator-payment', [PaymentGatewayController::class, 'simulator'])->name('payment.simulator');
Route::post('/simulator-payment/reset-demo', [PaymentGatewayController::class, 'resetDemo'])->name('payment.reset_demo');
Route::get('/payment-gateway/transactions', [PaymentGatewayController::class, 'getTransactions'])->name('payment.transactions');
Route::post('/payment-gateway/inquiry', [PaymentGatewayController::class, 'inquiry'])->name('payment.inquiry');
Route::post('/payment-gateway/callback', [PaymentGatewayController::class, 'callback'])->name('payment.callback');

