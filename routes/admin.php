<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController; // <-- Add this
use App\Http\Controllers\Admin\RoleController; // <-- Add this

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['can:manage-settings'])->group(function () {
        // Settings Routes
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });

    // menage users
    Route::middleware(['can:manage-users'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Role & Permission Management Routes
    Route::middleware(['can:manage-roles'])->group(function () {
        Route::resource('roles', RoleController::class);
    });



});

use App\Http\Controllers\Admin\PublicationTypeController;

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['can:manage-publication-types'])->group(function () {
        Route::resource('publication-types', PublicationTypeController::class)->except(['show']);
    });
});



// A route protected by a role
Route::middleware(['auth', 'verified', 'role:admin|super-admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index']);
});

use App\Http\Controllers\Admin\CircularController;
// ...

Route::middleware(['auth', 'verified', 'can:manage-circulars'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::resource('circulars', CircularController::class);

});
