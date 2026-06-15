<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DisableDayController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [BookingController::class, 'home'])->name('home');
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/booking/payment/{payment}', [BookingController::class, 'payment'])->name('booking.payment');
Route::get('/booking/receipt/{payment}', [BookingController::class, 'receipt'])->name('booking.receipt');

Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::redirect('/', '/admin/analytics');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/pengajuan', [AdminController::class, 'pengajuan'])->name('pengajuan');
    Route::post('/pengajuan/{pendaftar}/approve', [AdminController::class, 'approve'])->name('pengajuan.approve');
    Route::post('/pengajuan/{pendaftar}/reject', [AdminController::class, 'reject'])->name('pengajuan.reject');
    Route::get('/pengajuan/ditolak', [AdminController::class, 'pengajuanDitolak'])->name('pengajuan.ditolak');
    Route::get('/pembayaran', [AdminController::class, 'pembayaran'])->name('pembayaran');
    Route::post('/pembayaran/{payment}/paid', [AdminController::class, 'markPaid'])->name('pembayaran.paid');
    Route::post('/pembayaran/{payment}/request', [AdminController::class, 'requestPayment'])->name('pembayaran.request');
    Route::get('/history', [AdminController::class, 'history'])->name('history');
    Route::get('/history/{kunjungan}', [AdminController::class, 'historyDetail'])->name('history.detail');
    Route::get('/scanner', [AdminController::class, 'scanner'])->name('scanner');
    Route::get('/scan/check/{token}', [AdminController::class, 'scanCheck'])->name('scan.check');
    Route::post('/scan/{token}', [AdminController::class, 'scanToken'])->name('scan');

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/disable-days', [DisableDayController::class, 'index'])->name('disable-days.index');
    Route::get('/disable-days/create', [DisableDayController::class, 'create'])->name('disable-days.create');
    Route::post('/disable-days', [DisableDayController::class, 'store'])->name('disable-days.store');
    Route::get('/disable-days/{disableDay}/edit', [DisableDayController::class, 'edit'])->name('disable-days.edit');
    Route::put('/disable-days/{disableDay}', [DisableDayController::class, 'update'])->name('disable-days.update');
    Route::delete('/disable-days/{disableDay}', [DisableDayController::class, 'destroy'])->name('disable-days.destroy');
});

require __DIR__.'/settings.php';
