<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Organizer\CheckerController;
use App\Http\Controllers\Checker\DashboardController as CheckerDashboard;
use App\Http\Controllers\UserController;

// Route Public
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/about', [App\Http\Controllers\HomeController::class, 'about'])->name('about');
Route::get('/events', [App\Http\Controllers\EventController::class, 'allEvents'])->name('events.all');
Route::get('/event/{id}', [App\Http\Controllers\HomeController::class, 'show'])->name('event.show');
Route::get('/register/organizer', [App\Http\Controllers\Auth\RegisterController::class, 'showOrganizerRegisterForm'])->name('register.organizer');

// Auth Routes (Login, Register, Logout)
Auth::routes(['verify' => true]); // Mengaktifkan email verification

// Route yang membutuhkan Login
Route::middleware(['auth', 'verified'])->group(function () {

    // 1. AREA ADMIN
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
        // Kelola User, Role, Kategori, dll.
    });

    // 2. AREA ORGANIZER
    Route::middleware(['role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {
        Route::get('/dashboard', [OrganizerController::class, 'index'])->name('dashboard');
        Route::resource('events', App\Http\Controllers\EventController::class);
        Route::post('/events/{id}/assign', [EventController::class, 'assignCheckers'])->name('events.assign');
        Route::resource('checkers', CheckerController::class);
        Route::get('/verifications', [OrganizerController::class, 'verifications'])->name('verifications');

        // Proses Approve/Reject
        Route::post('/verifications/{id}/approve', [OrganizerController::class, 'approveTicket'])->name('tickets.approve');
        Route::post('/verifications/{id}/reject', [OrganizerController::class, 'rejectTicket'])->name('tickets.reject');
    });

    // 3. AREA CHECKER
    Route::middleware(['role:checker'])->prefix('checker')->name('checker.')->group(function () {
        Route::get('/dashboard', [CheckerDashboard::class, 'index'])->name('dashboard');
        Route::get('/scan/{id}', [CheckerController::class, 'scan'])->name('scan');
        Route::post('/verify/{eventId}', [CheckerController::class, 'verifyTicket'])->name('verify');
    });

    // 4. AREA USER (PEMBELI)
    Route::middleware(['role:user'])->group(function () {
        Route::get('/profile', [UserController::class, 'profile'])->name('profile');
        Route::get('/my-tickets', [UserController::class, 'tickets'])->name('my.tickets');
        Route::post('/my-tickets/upload/{id}', [UserController::class, 'uploadProof'])->name('user.tickets.upload');
        Route::get('/my-tickets/{id}', [UserController::class, 'showTicket'])->name('user.tickets.show');
        Route::get('/my-tickets/{id}/print', [UserController::class, 'printTicket'])->name('user.tickets.print');
        Route::get('/checkout/{id}', [UserController::class, 'showCheckout'])->name('checkout.show');
        Route::post('/checkout', [UserController::class, 'checkout'])->name('checkout');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
