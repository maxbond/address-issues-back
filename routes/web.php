<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\StreetController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\UserController;

Route::get('/admin/login', [LoginController::class, 'index'])->name('login');
Route::post('/admin/login', [LoginController::class, 'login'])->name('authenticate');

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'user_is_admin']], function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('locations', LocationController::class)->names('admin.locations');
    Route::resource('streets', StreetController::class)->names('admin.streets');
    Route::resource('addresses', AddressController::class)->names('admin.addresses');
    Route::resource('users', UserController::class)->names('admin.users');
    Route::put('users/{user}/restore', [UserController::class, 'restore'])->withTrashed()->name('admin.users.restore');
});
