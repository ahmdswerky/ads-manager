<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdvertisementController;

Route::apiResource('categories', CategoryController::class);
Route::apiResource('tags', TagController::class);
Route::apiResource('ads', AdvertisementController::class, [
    'parameters' => [
        'ads' => 'advertisement',
    ],
]);
