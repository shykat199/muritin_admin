<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\SongController;
use Illuminate\Support\Facades\Route;

Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category:slug}/songs', [SongController::class, 'byCategory']);
Route::get('songs', [SongController::class, 'index']);
Route::get('songs/{audio_id}', [SongController::class, 'show']);
