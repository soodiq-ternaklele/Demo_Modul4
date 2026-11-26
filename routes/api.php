<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MediaController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\UserCollectionController;

Route::apiResource('media', MediaController::class)
    ->parameters(['media' => 'media']);

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{user}', [UserController::class, 'show']);

Route::post('/users/{user}/collection', [UserCollectionController::class, 'store']);
Route::delete('/users/{user}/collection/{media}', [UserCollectionController::class, 'destroy']);
