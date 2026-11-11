<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/leadership', [PageController::class, 'leadership'])->name('leadership');
Route::get('/activities', [PageController::class, 'activities'])->name('activities');
Route::get('/news-events', [PageController::class, 'news'])->name('news');
Route::get('/gallery', [PageController::class, 'gallery'])->name('gallery');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
