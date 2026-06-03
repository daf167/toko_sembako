<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/login', [AuthController::class, 'showLogin']);
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:admin')->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('items', ItemController::class)->except(['index', 'show']);
        Route::resource('users', UserController::class);
    });

    Route::middleware('role:admin,staff,owner')->group(function () {
        Route::get('/items', [ItemController::class, 'index'])->name('items.index');
        Route::get('/items/{item}', [ItemController::class, 'show'])->name('items.show');
    });

    Route::middleware('role:admin,staff')->group(function () {
        Route::get('/inventory/stock', [InventoryController::class, 'stock'])->name('inventory.stock');
        Route::post('/inventory/stock', [InventoryController::class, 'store'])->name('inventory.store');
    });

    Route::middleware('role:admin,staff,owner')->group(function () {
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    });
});
