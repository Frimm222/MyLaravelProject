<?php

use App\Http\Controllers\API\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->name('api.users.')->group(function () {
    Route::get('', [UserController::class, 'index'])->name('index');
    Route::post('', [UserController::class, 'store'])->name('store');
    Route::get('{user}', [UserController::class, 'show'])->name('show');
    Route::patch('{user}', [UserController::class, 'update'])->name('update');
    Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
});

