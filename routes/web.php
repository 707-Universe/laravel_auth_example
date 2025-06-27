<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use App\Http\Controllers\V1\UserController;

Route::withoutMiddleware(VerifyCsrfToken::class)->group(function () {
    Route::post('/v1/user/create', [UserController::class, 'create']);
});

