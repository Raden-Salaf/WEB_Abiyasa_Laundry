<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Operator\DashboardController as OperatorDashboard;
use App\Http\Controllers\Pimpinan\DashboardController as PimpinanDashboard;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TypeOfServiceController;
use App\Http\Controllers\Operator\TransOrderController;
use App\Http\Controllers\Operator\TransLaundryPickupController;
use App\Http\Controllers\Pimpinan\LaporanController;
use Illuminate\Support\Facades\Route;

// Halaman utama diarahkan ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk autentikasi (login & logout)
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route khusus Administrator, dilindungi middleware role
Route::middleware(['role:Administrator', 'prevent-back-history'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Master data: Customer
    Route::resource('customer', CustomerController::class)->except('show');

    // Master data: User
    Route::resource('user', UserController::class)->except('show');

    // Master data: Jenis Service
    Route::resource('service', TypeOfServiceController::class)->except('show');
});

// Route khusus Operator, dilindungi middleware role
Route::middleware(['role:Operator,Administrator', 'prevent-back-history'])->prefix('operator')->name('operator.')->group(function () {
    Route::get('/dashboard', [OperatorDashboard::class, 'index'])->name('dashboard');

    // Transaksi laundry (input order baru)
    Route::resource('order', TransOrderController::class)->only(['index', 'create', 'store', 'show']);

    // Transaksi pengambilan laundry
    Route::get('/pickup', [TransLaundryPickupController::class, 'index'])->name('pickup.index');
    Route::get('/pickup/{order}/create', [TransLaundryPickupController::class, 'create'])->name('pickup.create');
    Route::post('/pickup/{order}/store', [TransLaundryPickupController::class, 'store'])->name('pickup.store');
});

// Route khusus Pimpinan, dilindungi middleware role
Route::middleware(['role:Pimpinan,Administrator', 'prevent-back-history'])->prefix('pimpinan')->name('pimpinan.')->group(function () {
    Route::get('/dashboard', [PimpinanDashboard::class, 'index'])->name('dashboard');

    // Laporan penjualan (read-only)
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('/laporan/{order}', [LaporanController::class, 'show'])->name('laporan.show');
});
