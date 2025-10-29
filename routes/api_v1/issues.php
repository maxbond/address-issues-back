<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\IssueController;

Route::apiResource('issues', IssueController::class);
Route::post('issues/{issue}/comment', [IssueController::class, 'storeComment'])->name('issues.comment.store');
Route::delete('issues/comment/{issueComment}', [IssueController::class, 'destroyComment'])->name('issues.comment.destroy');
