<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\TagController;

Route::apiResource('tags', TagController::class);
Route::get('tags/{tag}/issues', [TagController::class, "issues"])->name('tags.issues');
