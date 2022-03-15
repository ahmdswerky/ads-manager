<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CategoryController;

Route::apiResource('categories', CategoryController::class);
Route::apiResource('tags', TagController::class);
