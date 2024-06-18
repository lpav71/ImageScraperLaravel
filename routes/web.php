<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\ImageController::class, 'index'])->name('index');
Route::post('/fetch-images', [App\Http\Controllers\ImageController::class, 'fetchImages'])->name('fetch-images');
