<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/prestations', [ServiceController::class, 'index'])->name('services.index');
Route::get('/galerie', [PageController::class, 'gallery'])->name('gallery');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/reservation', [BookingController::class, 'create'])->name('booking.create');
Route::post('/reservation', [BookingController::class, 'store'])->name('booking.store');
Route::get('/reservation/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

Route::middleware('guest')->group(function () {
    Route::get('/connexion', [LoginController::class, 'create'])->name('login');
    Route::post('/connexion', [LoginController::class, 'store'])->middleware('throttle:5,1');
});

Route::post('/deconnexion', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::patch('/reservations/{booking}', [AdminBookingController::class, 'update'])->name('bookings.update');
    Route::delete('/reservations/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
});
