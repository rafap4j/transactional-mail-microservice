<?php

use App\Applications\Api\v1\Http\Controllers\EmailController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    /**
     * E-mail routes.
     */
    Route::prefix('email')->group(function () {
        Route::post('send', [EmailController::class, 'send'])->name('email.send');
    });
});
