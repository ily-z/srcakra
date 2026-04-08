<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return redirect('/booking');
});
// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::inertia('dashboard', 'dashboard')->name('dashboard');
// });

// Route::get('/booking', [ReservationController::class, 'create']);
// Route::post('/reservations', [ReservationController::class, 'store']);

require __DIR__.'/settings.php';
