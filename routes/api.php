<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Resources\User\UserResource;

Route::controller(LoginController::class)->group(function () {
    Route::post('login', 'login')->name('api.login');
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:sanctum', 'active_user']], function () {
    Route::get('/user/', function () {
        return new UserResource(auth()->user());
    });
    require __DIR__ . '/api_v1/issues.php';
    require __DIR__ . '/api_v1/addresses.php';
    require __DIR__ . '/api_v1/tags.php';
    require __DIR__ . '/api_v1/executors.php';
});
