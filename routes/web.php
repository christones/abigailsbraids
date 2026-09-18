<?php

use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController as AdminGalleryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ServiceCategoryController as AdminServiceCategoryController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\ServiceOptionController as AdminServiceOptionController;
use App\Http\Controllers\Admin\TrainingController as AdminTrainingController;
use App\Http\Controllers\Admin\TrainingRegistrationController as AdminTrainingRegistrationController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingRegistrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/prestations', [ServiceController::class, 'index'])->name('services.index');
Route::get('/galerie', [PageController::class, 'gallery'])->name('gallery');
Route::get('/boutique', [ProductController::class, 'index'])->name('products.index');
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

    // Inscriptions aux formations (demandes reçues via le site)
    Route::get('/formations/inscriptions', [AdminTrainingRegistrationController::class, 'index'])->name('training-registrations.index');
    Route::patch('/formations/inscriptions/{trainingRegistration}', [AdminTrainingRegistrationController::class, 'update'])->name('training-registrations.update');
    Route::delete('/formations/inscriptions/{trainingRegistration}', [AdminTrainingRegistrationController::class, 'destroy'])->name('training-registrations.destroy');

    // Catalogue des prestations
    Route::get('/prestations', [AdminServiceController::class, 'index'])->name('services.index');
    Route::get('/prestations/nouvelle', [AdminServiceController::class, 'create'])->name('services.create');
    Route::post('/prestations', [AdminServiceController::class, 'store'])->name('services.store');
    Route::get('/prestations/{service}/modifier', [AdminServiceController::class, 'edit'])->name('services.edit');
    Route::patch('/prestations/{service}', [AdminServiceController::class, 'update'])->name('services.update');
    Route::delete('/prestations/{service}', [AdminServiceController::class, 'destroy'])->name('services.destroy');
    Route::patch('/prestations/{service}/monter', [AdminServiceController::class, 'moveUp'])->name('services.move-up');
    Route::patch('/prestations/{service}/descendre', [AdminServiceController::class, 'moveDown'])->name('services.move-down');

    // Catégories de prestations
    Route::get('/prestations/categories', [AdminServiceCategoryController::class, 'index'])->name('service-categories.index');
    Route::get('/prestations/categories/nouvelle', [AdminServiceCategoryController::class, 'create'])->name('service-categories.create');
    Route::post('/prestations/categories', [AdminServiceCategoryController::class, 'store'])->name('service-categories.store');
    Route::get('/prestations/categories/{serviceCategory}/modifier', [AdminServiceCategoryController::class, 'edit'])->name('service-categories.edit');
    Route::patch('/prestations/categories/{serviceCategory}', [AdminServiceCategoryController::class, 'update'])->name('service-categories.update');
    Route::delete('/prestations/categories/{serviceCategory}', [AdminServiceCategoryController::class, 'destroy'])->name('service-categories.destroy');
    Route::patch('/prestations/categories/{serviceCategory}/monter', [AdminServiceCategoryController::class, 'moveUp'])->name('service-categories.move-up');
    Route::patch('/prestations/categories/{serviceCategory}/descendre', [AdminServiceCategoryController::class, 'moveDown'])->name('service-categories.move-down');

    // Options / variantes d'une prestation
    Route::get('/prestations/{service}/options', [AdminServiceOptionController::class, 'index'])->name('services.options.index');
    Route::get('/prestations/{service}/options/nouvelle', [AdminServiceOptionController::class, 'create'])->name('services.options.create');
    Route::post('/prestations/{service}/options', [AdminServiceOptionController::class, 'store'])->name('services.options.store');
    Route::get('/prestations/{service}/options/{option}/modifier', [AdminServiceOptionController::class, 'edit'])->name('services.options.edit');
    Route::patch('/prestations/{service}/options/{option}', [AdminServiceOptionController::class, 'update'])->name('services.options.update');
    Route::delete('/prestations/{service}/options/{option}', [AdminServiceOptionController::class, 'destroy'])->name('services.options.destroy');
    Route::patch('/prestations/{service}/options/{option}/monter', [AdminServiceOptionController::class, 'moveUp'])->name('services.options.move-up');
    Route::patch('/prestations/{service}/options/{option}/descendre', [AdminServiceOptionController::class, 'moveDown'])->name('services.options.move-down');

    // Catalogue des formations
    Route::get('/formations', [AdminTrainingController::class, 'index'])->name('trainings.index');
    Route::get('/formations/nouvelle', [AdminTrainingController::class, 'create'])->name('trainings.create');
    Route::post('/formations', [AdminTrainingController::class, 'store'])->name('trainings.store');
    Route::get('/formations/{training}/modifier', [AdminTrainingController::class, 'edit'])->name('trainings.edit');
    Route::patch('/formations/{training}', [AdminTrainingController::class, 'update'])->name('trainings.update');
    Route::delete('/formations/{training}', [AdminTrainingController::class, 'destroy'])->name('trainings.destroy');
    Route::patch('/formations/{training}/monter', [AdminTrainingController::class, 'moveUp'])->name('trainings.move-up');
    Route::patch('/formations/{training}/descendre', [AdminTrainingController::class, 'moveDown'])->name('trainings.move-down');

    // Galerie
    Route::get('/galerie', [AdminGalleryController::class, 'index'])->name('gallery.index');
    Route::get('/galerie/ajouter', [AdminGalleryController::class, 'create'])->name('gallery.create');
    Route::post('/galerie', [AdminGalleryController::class, 'store'])->name('gallery.store');
    Route::get('/galerie/{galleryImage}/modifier', [AdminGalleryController::class, 'edit'])->name('gallery.edit');
    Route::patch('/galerie/{galleryImage}', [AdminGalleryController::class, 'update'])->name('gallery.update');
    Route::delete('/galerie/{galleryImage}', [AdminGalleryController::class, 'destroy'])->name('gallery.destroy');
    Route::patch('/galerie/{galleryImage}/monter', [AdminGalleryController::class, 'moveUp'])->name('gallery.move-up');
    Route::patch('/galerie/{galleryImage}/descendre', [AdminGalleryController::class, 'moveDown'])->name('gallery.move-down');

    // Boutique (produits capillaires)
    Route::get('/boutique', [AdminProductController::class, 'index'])->name('products.index');
    Route::get('/boutique/nouveau', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/boutique', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/boutique/{product}/modifier', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::patch('/boutique/{product}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/boutique/{product}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    Route::patch('/boutique/{product}/monter', [AdminProductController::class, 'moveUp'])->name('products.move-up');
    Route::patch('/boutique/{product}/descendre', [AdminProductController::class, 'moveDown'])->name('products.move-down');
});
