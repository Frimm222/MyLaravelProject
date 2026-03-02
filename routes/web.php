<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\Web\UserController;
use App\Http\Middleware\CheckStatusForAdminMiddleware;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::middleware('auth')->group(function(){
    // DASHBOARD CONTROLLER
    Route::get('', [DashboardController::class, 'index'])->name('dashboard');

    // MUSIC CONTROLLER
    Route::prefix('music')->name('music.')->group(function () {
        Route::get('', [MusicController::class, 'index'])->name('index');
        Route::get('create', [MusicController::class, 'create'])->name('create')->middleware(CheckStatusForAdminMiddleware::class);
        Route::get('{music}', [MusicController::class, 'show'])->name('show');
        Route::delete('{music}', [MusicController::class, 'delete'])->name('delete')->middleware(CheckStatusForAdminMiddleware::class);
        Route::get('{music}/edit', [MusicController::class, 'edit'])->name('edit')->middleware(CheckStatusForAdminMiddleware::class);
        Route::patch('{music}', [MusicController::class, 'update'])->name('update')->middleware(CheckStatusForAdminMiddleware::class);
        Route::post('', [MusicController::class, 'store'])->name('store');
        Route::post('save/favorite/{music}', [MusicController::class, 'saveFavorite'])->name('save.favorite');
        Route::post('track/listen-progress', [MusicController::class, 'trackListenProgress'])->name('track.listen_progress');
    });

    // USER CONTROLLER
    Route::resource('users', UserController::class)->except('edit')->middleware(CheckStatusForAdminMiddleware::class);
    Route::get('users/{slug}/edit', [UserController::class, 'edit'])->name('users.edit');

    // FAVORITE CONTROLLER
    Route::get('favorites', [FavoriteController::class, 'index'])->name('favorites.index');
});
