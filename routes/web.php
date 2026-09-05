<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\TrainingRegistrationController as AdminTrainingRegistrationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/prestations', [ServiceController::class, 'index'])->name('services.index');
Route::get('/galerie', [PageController::class, 'gallery'])->name('gallery');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

Route::get('/reservation', [BookingController::class, 'create'])->name('booking.create');
Route::post('/reservation', [BookingController::class, 'store'])->name('booking.store');
Route::get('/reservation/confirmation/{booking}', [BookingController::class, 'confirmation'])->name('booking.confirmation');

Route::get('/formations', [TrainingController::class, 'index'])->name('trainings.index');
Route::get('/formations/inscription', [TrainingRegistrationController::class, 'create'])->name('training.create');
Route::post('/formations/inscription', [TrainingRegistrationController::class, 'store'])->name('training.store');
Route::get('/formations/inscription/confirmation/{trainingRegistration}', [TrainingRegistrationController::class, 'confirmation'])->name('training.confirmation');

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

    Route::get('/formations', [AdminTrainingRegistrationController::class, 'index'])->name('trainings.index');
    Route::patch('/formations/{trainingRegistration}', [AdminTrainingRegistrationController::class, 'update'])->name('trainings.update');
    Route::delete('/formations/{trainingRegistration}', [AdminTrainingRegistrationController::class, 'destroy'])->name('trainings.destroy');
});
