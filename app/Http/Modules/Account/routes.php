<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\Account\Controllers\ProfilesController;
use App\Http\Modules\Account\Controllers\Users\EmailController;
use App\Http\Modules\Account\Controllers\Users\PasswordController;
use App\Http\Modules\Account\Controllers\Users\UsersController;

/**
 * Users
 **/
Route::prefix('users')->group(function () {
    Route::post('', [UsersController::class, 'create']);
    Route::post('login', [UsersController::class, 'login']);
    Route::middleware('auth:sanctum')->patch('{id}', [UsersController::class, 'update']);
    Route::middleware('auth:sanctum')->post('logout', [UsersController::class, 'logout']);
    Route::middleware('auth:sanctum')->get('current', [UsersController::class, 'current']);

    Route::prefix('email')->group(function() {
        Route::middleware(['auth:sanctum', 'throttle:6,1'])
            ->get('send-verification-notice', [EmailController::class, 'sendVerificationNotice'])
            ->name('verification.send');
        Route::middleware(['throttle:6,1'])
            ->get('verify/{id}/{hash}', [EmailController::class, 'verify'])
            ->name('verification.verify');
    });

    Route::prefix('password')->group(function() {
        /**
         * Отправляет уведомление о сбросе пароля на электронную почту.
         */
        Route::post('send-reset-notice', [PasswordController::class, 'sendResetNotice'])
            ->name('password.email');
        /**
         * Идентифицирует токен сброса пароля.
         */
        Route::middleware('guest')
            ->post('check-reset-token', [PasswordController::class, 'checkResetToken']);
        /**
         * Сбрасывает пароль учетной записи.
         */
        Route::middleware('guest')
            ->patch('reset/{token}', [PasswordController::class, 'reset'])
            ->name('password.reset');
    });
});

/**
 * Profiles
 **/
Route::prefix('profiles')->group(function () {
    Route::post('', [ProfilesController::class, 'create']);
    Route::get('{id}', [ProfilesController::class, 'get']);
    Route::middleware('auth:sanctum')->patch('{id}', [ProfilesController::class, 'update']);
    Route::post('search', [ProfilesController::class, 'search']);
    Route::post('search-one', [ProfilesController::class, 'searchOne']);
});

/**
 * Profiles
 **/
Route::prefix('friends')->group(function () {
    Route::get('{id}', [FriendsController::class, 'get']);
    Route::get('fiend', [FriendsController::class, 'fiend']);
    Route::get('fiend', [FriendsController::class, 'fiend']);
    Route::middleware('auth:sanctum')->post('current', [FriendsController::class, 'current']);
    Route::middleware('auth:sanctum')->post('', [FriendsController::class, 'create']);
    Route::middleware('auth:sanctum')->patch('{id}/confirm', [FriendsController::class, 'confirm']);
    Route::middleware('auth:sanctum')->delete('{id}', [FriendsController::class, 'delete']);
    Route::post('search', [FriendsController::class, 'search']);
    Route::post('search-one', [FriendsController::class, 'searchOne']);
});
