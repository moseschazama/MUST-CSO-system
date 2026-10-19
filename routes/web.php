<?php

use App\Http\Controllers\Admin\AuthenticatedSessionController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventController as AdminEventController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HealthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{event:slug}', [EventController::class, 'show'])->name('events.show');

Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->middleware('throttle:6,1')
    ->name('contact.store');

Route::get('/health', HealthController::class)->name('health');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login.store');

    Route::middleware('auth')->group(function () {
        Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    });

    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/', DashboardController::class)->name('dashboard');

        Route::get('events', [AdminEventController::class, 'index'])->name('events.index');
        Route::get('events/create', [AdminEventController::class, 'create'])->name('events.create');
        Route::post('events', [AdminEventController::class, 'store'])->name('events.store');
        Route::get('events/{event:id}/edit', [AdminEventController::class, 'edit'])->name('events.edit');
        Route::put('events/{event:id}', [AdminEventController::class, 'update'])->name('events.update');
        Route::delete('events/{event:id}', [AdminEventController::class, 'destroy'])->name('events.destroy');

        Route::get('messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
        Route::patch('messages/{message}/read', [AdminContactMessageController::class, 'toggleRead'])->name('messages.toggle-read');
    });
});
