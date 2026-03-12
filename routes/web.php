<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;

// HOME PAGE
Route::get('/', function () {
    return view('home');
})->name('home');

// Breeze authenticatie routes (die bevatten al register/login)
require __DIR__.'/auth.php';

// Logout (als je eigen logout wilt naast Breeze)
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

// Beschermde routes voor ingelogde gebruikers
Route::middleware(['auth'])->group(function () {
    // Dashboard omleiding (overschrijft de Breeze dashboard)
    Route::get('/dashboard', function () {
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('player.dashboard');
    })->name('dashboard');

    // Speler dashboard
    Route::get('/player/dashboard', function () {
        return view('player.dashboard');
    })->name('player.dashboard');

    // Profiel routes
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile');
    Route::get('/profile/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('/password/change', [App\Http\Controllers\ProfileController::class, 'passwordForm'])->name('password.change');
    Route::post('/password/update', [App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('password.update');

    // Catalogus
    Route::get('/items', [App\Http\Controllers\ItemController::class, 'index'])->name('items.index');
    Route::get('/items/{item}', [App\Http\Controllers\ItemController::class, 'show'])->name('items.show');

    // Inventaris
    Route::get('/inventory', [App\Http\Controllers\InventoryController::class, 'index'])->name('inventory.index');

    // Handel
    Route::resource('trades', App\Http\Controllers\TradeController::class)->except(['edit', 'update']);
    Route::post('/trades/{trade}/accept', [App\Http\Controllers\TradeController::class, 'accept'])->name('trades.accept');
    Route::post('/trades/{trade}/decline', [App\Http\Controllers\TradeController::class, 'decline'])->name('trades.decline');

    // Notificaties
    Route::get('/notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('notifications.read');

    // Admin routes
    Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Gebruikersbeheer
        Route::resource('users', App\Http\Controllers\Admin\UserController::class);
        Route::get('/users/{user}/inventory', [App\Http\Controllers\Admin\UserController::class, 'inventory'])->name('users.inventory');

        // Itembeheer
        Route::resource('items', App\Http\Controllers\Admin\ItemController::class);

        // Item toekennen - ALLE routes compleet
        Route::get('/assign-item/index', [App\Http\Controllers\Admin\InventoryController::class, 'index'])->name('assign-item.index');
        Route::get('/assign-item', [App\Http\Controllers\Admin\InventoryController::class, 'assignForm'])->name('assign-item.form');
        Route::post('/assign-item', [App\Http\Controllers\Admin\InventoryController::class, 'assign'])->name('assign-item');
        Route::put('/assign-item/{id}', [App\Http\Controllers\Admin\InventoryController::class, 'updateQuantity'])->name('assign-item.update'); // <- DEZE ONTBRAK
        Route::delete('/assign-item/{id}', [App\Http\Controllers\Admin\InventoryController::class, 'destroy'])->name('assign-item.destroy');

        // Rapportages
        Route::get('/reports/item-type', [App\Http\Controllers\Admin\ReportController::class, 'itemTypeReport'])->name('reports.item-type');
    });
});
