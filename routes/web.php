<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\offerController;
use App\Http\Controllers\Admin\admin_panelController;
use App\Http\Controllers\Admin\AdminOfferController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClickTrackingController;


Route::get('/', function () {
    return view('welcome');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::middleware(['auth', 'role:user'])->group(function () {
    // Маршруты для пользователей

    Route::get('/dashboard', [DashboardController::class, 'showUserOffers'])
        ->middleware(['auth', 'verified'])
        ->name('dashboard');

    Route::post('/createOffer', [OfferController::class, 'create'])
        ->middleware(['auth', 'verified'])
        ->name('createOffer');

    Route::get('/dashboard/{id}/delete', [OfferController::class, 'deleteOffer'])
        ->middleware(['auth', 'verified'])
        ->name('deleteOffer');

    Route::post('/dashboard/{id}/edit', [OfferController::class, 'editOffer'])
        ->middleware(['auth', 'verified'])
        ->name('editOffer');

    Route::get('/dashboard/{id}', [OfferController::class, 'offerPage'])
        ->middleware(['auth', 'verified'])
        ->name('offerPage');
});




Route::middleware(['auth', 'role:admin'])->group(function () {
    // Маршруты для администраторов

    Route::get('/admin_panel', [admin_panelController::class, 'showUserOffers'])
        ->middleware(['auth', 'verified'])
        ->name('admin_panel');

        Route::get('/admin_panel/{id}', [AdminOfferController::class, 'offerPage'])
        ->middleware(['auth', 'verified'])
        ->name('offerPage');

        Route::post('/admin_panel/{id}/sign', [admin_panelController::class, 'signToOffer'])
        ->middleware(['auth', 'verified'])
        ->name('signToOffer');
        
        Route::post('/admin_panel/{id}/unSubscribe', [AdminOfferController::class, 'unSubscribe'])
        ->middleware(['auth', 'verified'])
        ->name('unSubscribe');
        
        Route::get('/admin_panel/{id}/sign', [admin_panelController::class, 'signToOffer'])
        ->middleware(['auth', 'verified'])
        ->name('signToOffer');
        
        Route::get('/admin_panel/{id}/unSubscribe', [AdminOfferController::class, 'unSubscribe'])
        ->middleware(['auth', 'verified'])
        ->name('unSubscribe');
        
});

Route::get('/track-click', [ClickTrackingController::class, 'trackClick'])->name('track.click');



require __DIR__ . '/auth.php';
