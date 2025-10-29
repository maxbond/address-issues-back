<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\ExecutorController;

Route::get('executors', [ExecutorController::class, "active"])->name('executors.active');
