<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TrainController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\MethodController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\DriverController;              // <-- sudah ada
use App\Http\Controllers\Auth\DriverAuthController;     // sudah ada
use App\Http\Controllers\DriverDashboardController;     // <-- TAMBAHKAN INI

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
});

Route::get('/about', function () {
    return view('about');
});

Route::get('/destination', function () {
    return view('destination');
});

Route::get('/contact', function () {
    return view('contact');
});

// Route group for authenticated and verified users
Route::middleware(['auth', 'verified'])->group(function () {
    // Print Testing Route
    Route::get('/print', [PrintController::class, 'index']);
    Route::get('/printpdf', [PrintController::class, 'print']);

    // Complaint Route
    Route::resource('/complaints', ComplaintController::class);

    // Dashboard Route (user biasa)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Order Route
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders',        [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders',         [OrderController::class, 'index'])->name('orders.index');

    // Detail Order (letakkan SETELAH routes 'search' & 'availability')
Route::get('/orders/{order}', [OrderController::class, 'show'])
     ->whereNumber('order')
     ->name('orders.show');

    // cari tiket yang tersedia berdasar asal, tujuan, tanggal
    Route::get('/orders/search',       [OrderController::class, 'searchTickets'])->name('orders.search');
    Route::get('/orders/availability', [OrderController::class, 'availability'])->name('orders.availability');

    // Transaction Route
    Route::get('/transactions',                         [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}/edit',      [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}',           [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}',        [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Train Route
    Route::resource('/trains', TrainController::class)->middleware('can:isAdmin');

    // Track Route
    Route::resource('/tracks', TrackController::class)->middleware('can:isAdmin');

    // Ticket Route
    Route::resource('/tickets', TicketController::class);

    // Price Route
    Route::resource('/prices', PriceController::class);

    // Method Route
    Route::resource('/methods', MethodController::class)->middleware('can:isAdmin');

    // User Route
    Route::resource('/users', UserController::class);

    // routes/web.php
    Route::delete('/profile/delete-image', [UserController::class, 'deleteImage'])->name('user.deleteImage');

    // Check Price Route
    Route::get('/checkprice', [OrderController::class, 'checkprice']);

    // ====== CRUD Driver untuk admin ======
    Route::resource('/drivers', DriverController::class)->middleware('can:isAdmin');
});
// ====== Auth Driver (guard: driver) ======
Route::prefix('driver')->name('driver.')->group(function () {
    // Login & Register (hanya untuk yang BELUM login sebagai driver)
    Route::middleware('guest:driver')->group(function () {
        Route::get('login',    [DriverAuthController::class, 'showLogin'])->name('login');
        Route::post('login',   [DriverAuthController::class, 'login'])->name('login.post');

        // Opsional: hapus kalau driver tidak boleh daftar sendiri
        Route::get('register', [DriverAuthController::class, 'showRegister'])->name('register');
        Route::post('register',[DriverAuthController::class, 'register'])->name('register.post');
    });

    // Dashboard & Logout (hanya driver yang SUDAH login)
    Route::middleware('auth:driver')->group(function () {
        Route::get('dashboard', [DriverDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout',   [DriverAuthController::class, 'logout'])->name('logout');
    });
});
