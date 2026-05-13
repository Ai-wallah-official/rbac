<?php
/*
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
*/

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('products.index');
});

// Customer routes
Route::middleware(['auth'])->group(function () {
    Route::get('/products', [CustomerProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('products.show');
});

// Admin & Manager routes
Route::prefix('admin')
     ->name('admin.')
     ->middleware(['auth', 'role:Admin,Manager'])
     ->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::resource('products', ProductController::class);

    // Categories
    Route::resource('categories', CategoryController::class);

    // Users (Admin only)
    Route::middleware('role:Admin')->group(function () {
        Route::resource('users', UserController::class)->except(['create', 'store']);
    });
});

// Redirect dashboard
Route::middleware(['auth'])->get('/dashboard', function () {
    if (auth()->user()->hasRole(['Admin', 'Manager'])) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('products.index');
})->name('dashboard');

require __DIR__ . '/auth.php';