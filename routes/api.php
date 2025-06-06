<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

// Return authenticated user info
Route::middleware(['auth:sanctum', 'admin'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::apiResource('users', UserController::class)->except(['create', 'edit']);
    Route::post('users/delete-multiple', [UserController::class, 'destroyMultiple']); 
});