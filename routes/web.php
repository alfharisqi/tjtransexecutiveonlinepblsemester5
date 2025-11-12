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
use App\Http\Controllers\DriverController;
use App\Http\Controllers\Auth\DriverAuthController;
use App\Http\Controllers\DriverDashboardController;
use App\Http\Controllers\Driver\StatusPerjalananController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\ExpensePresetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketFinanceController;
use App\Http\Controllers\TripSettlementController;

require __DIR__ . '/auth.php';

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', fn() => view('landing'));
Route::get('/about', fn() => view('about'));
Route::get('/destination', fn() => view('destination'));
Route::get('/contact', fn() => view('contact'));

// ========================== AUTH + VERIFIED ==========================
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Print
    Route::get('/print',    [PrintController::class, 'index']);
    Route::get('/printpdf', [PrintController::class, 'print']);

    // Complaint
    Route::resource('/complaints', ComplaintController::class);

    // Dashboard (user biasa)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Orders
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders',        [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders',         [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/search',       [OrderController::class, 'searchTickets'])->name('orders.search');
    Route::get('/orders/availability', [OrderController::class, 'availability'])->name('orders.availability');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->whereNumber('order')->name('orders.show');
    Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->whereNumber('order')->name('orders.destroy');

    // Transactions
    Route::get('/transactions',                  [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('transactions.edit');
    Route::put('/transactions/{transaction}',    [TransactionController::class, 'update'])->name('transactions.update');
    Route::delete('/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('transactions.destroy');

    // Master data (Admin only)
    Route::resource('/trains',  TrainController::class)->middleware('can:isAdmin');
    Route::resource('/tracks',  TrackController::class)->middleware('can:isAdmin');
    Route::resource('/methods', MethodController::class)->middleware('can:isAdmin');
    Route::resource('/users',   UserController::class);

    // Tickets & Prices
    Route::resource('/tickets', TicketController::class);
    Route::resource('/prices',  PriceController::class);

    // Utility
    Route::delete('/profile/delete-image', [UserController::class, 'deleteImage'])->name('user.deleteImage');
    Route::get('/checkprice', [OrderController::class, 'checkprice']);

    // Drivers (Admin)
    Route::resource('/drivers', DriverController::class)->middleware('can:isAdmin');

   Route::get('/finance', [FinanceController::class, 'summary'])->name('finance.summary');

    // CRUD biaya
    Route::post('/finance/expenses', [FinanceController::class, 'storeExpense'])->name('finance.expense.store');
    Route::delete('/finance/expenses/{expense}', [FinanceController::class, 'destroyExpense'])->name('finance.expense.destroy');

    // Preset biaya
    Route::post('/expense-presets', [ExpensePresetController::class, 'store'])->name('expense_presets.store');
    Route::delete('/expense-presets/{preset}', [ExpensePresetController::class, 'destroy'])->name('expense_presets.destroy');
});





// ========================== DRIVER AUTH (guard: driver) ==========================
Route::prefix('driver')->name('driver.')->group(function () {
    Route::middleware('guest:driver')->group(function () {
        Route::get('login',    [DriverAuthController::class, 'showLogin'])->name('login');
        Route::post('login',   [DriverAuthController::class, 'login'])->name('login.post');
        Route::get('register', [DriverAuthController::class, 'showRegister'])->name('register');
        Route::post('register',[DriverAuthController::class, 'register'])->name('register.post');
    });

    Route::middleware('auth:driver')->group(function () {
        Route::get('dashboard', [DriverDashboardController::class, 'index'])->name('dashboard');
        Route::post('logout',   [DriverAuthController::class, 'logout'])->name('logout');
        Route::patch('status-perjalanan/{order}', [StatusPerjalananController::class, 'update'])
            ->name('status-perjalanan.update');
    });
});
