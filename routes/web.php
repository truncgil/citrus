<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\BlogController;

// Home -> admin'de işaretli anasayfayı (veya 'home' slug'ını) göster
Route::get('/', [PageController::class, 'index'])->name('home');
Route::get('/{slug}', [PageController::class, 'show'])->name('page.show');

// Blog
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
