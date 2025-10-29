<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AddressController;
use App\Http\Controllers\Api\V1\LocationController;
use App\Http\Controllers\Api\V1\StreetController;

Route::apiResource('addresses', AddressController::class);
Route::apiResource('locations', LocationController::class);
Route::apiResource('streets', StreetController::class);
