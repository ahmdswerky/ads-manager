<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;

Route::apiResource('tags', TagController::class);
