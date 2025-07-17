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

// Route::middleware(['auth', 'verified', 'can:manage-circulars'])
//     ->prefix('admin')
//     ->name('admin.')
//     ->group(function () {

//         Route::resource('circulars', CircularController::class);

// });

// use App\Http\Controllers\Admin\AdminDashboardController;

use App\Http\Controllers\Admin\ApplicationManagementController;
// use App\Http\Controllers\Admin\CircularController;
use App\Http\Controllers\Admin\JobManagementController;

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {

    // --- Circulars Management ---
    Route::middleware(['can:manage-circulars'])->group(function () {
        // The main index page for all circulars
        Route::get('/circulars', [CircularController::class, 'index'])->name('circulars.index');

        // CRUD routes for circulars
        Route::get('/circulars/create', [CircularController::class, 'create'])->name('circulars.create');
        Route::post('/circulars', [CircularController::class, 'store'])->name('circulars.store');
        Route::get('/circulars/{circular}/edit', [CircularController::class, 'edit'])->name('circulars.edit');
        Route::put('/circulars/{circular}', [CircularController::class, 'update'])->name('circulars.update');
        Route::delete('/circulars/{circular}', [CircularController::class, 'destroy'])->name('circulars.destroy');

        // NEW: The route to list all job posts within a circular
        Route::get('/circulars/{circular}/jobs', [JobManagementController::class, 'index'])->name('circulars.jobs.index');
    });

    // --- Application Management ---
    Route::middleware(['can:view-applications'])->group(function () {
        // NEW: The route to list all applications for a single job post
        Route::get('/jobs/{job}/applications', [ApplicationManagementController::class, 'indexForJob'])->name('jobs.applications.index');

        // The route to show a single application's snapshot
        Route::get('/applications/{application}', [ApplicationManagementController::class, 'show'])->name('applications.show');
    });

    Route::middleware(['can:update-application-status'])->group(function () {
        Route::put('/applications/{application}/status', [ApplicationManagementController::class, 'updateStatus'])->name('applications.status.update');
    });

     Route::post('/applications/bulk-update-status', [ApplicationManagementController::class, 'bulkUpdateStatus'])->name('applications.status.bulk-update');


    // ... (your other user, role, settings routes)
});
