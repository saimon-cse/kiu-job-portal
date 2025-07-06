<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AdminDashboardController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\user\ProfilePreviewController;

use App\Http\Controllers\User\EducationController;
use App\Http\Controllers\User\ExperienceController;
use App\Http\Controllers\User\PublicationController;
use App\Http\Controllers\User\LanguageController;
use App\Http\Controllers\User\RefereeController;
use App\Http\Controllers\User\TrainingController;
use App\Http\Controllers\User\DocumentController;
use App\Http\Controllers\User\AwardController;
use App\Http\Controllers\User\SettingsController as UserSettingsController;
// use App\Http\Controllers\User\PublicationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// routes/web.php
Route::middleware('auth')->group(function () {
    // --- Personal Information / Profile Routes ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // This route shows the page with password and account deletion forms.
    Route::get('/settings', UserSettingsController::class)->name('profile.settings');

    Route::get('/my-profile/preview', [ProfilePreviewController::class, 'show'])->name('profile.preview');



    // ---------------------------------------------------------------------
    // TYPE B: "Multiple Records" Management Routes (The Rest)
    // ---------------------------------------------------------------------
    // For these, we use `Route::resource`. This is a powerful helper that automatically
    // creates all the necessary CRUD routes for a resource.
    // (index, create, store, edit, update, destroy)

    // Manages Education records (List, Create, Edit, Delete)
    Route::resource('education', EducationController::class)->except(['show']);
    Route::post('/education/reorder', [EducationController::class, 'reorder'])->name('education.reorder');
    // Manages Work Experience records
    Route::resource('experience', ExperienceController::class)->except(['show']);
    Route::post('/experience/reorder', [ExperienceController::class, 'reorder'])->name('experience.reorder');
    // Manages Publication records
    Route::resource('publication', PublicationController::class)->except(['show']);

    // Manages Language Proficiency records
    Route::resource('language', LanguageController::class)->except(['show']);
    Route::post('/languages/reorder', [LanguageController::class, 'reorder'])->name('language.reorder');
    // Manages Referee records
    Route::resource('referee', RefereeController::class)->except(['show']);
    Route::post('/referees/reorder', [RefereeController::class, 'reorder'])->name('referee.reorder');
    // Manages Training records
    Route::resource('training', TrainingController::class)->except(['show']);
    Route::post('/training/reorder', [TrainingController::class, 'reorder'])->name('training.reorder');


    Route::resource('award', AwardController::class)->except(['show']);

    // The route to handle the reordering post request for awards
    Route::post('/awards/reorder', [AwardController::class, 'reorder'])->name('award.reorder');

    // Manages Document records
    Route::resource('document', DocumentController::class)->except(['show']);
});




Route::middleware(['auth', 'verified'])->group(function () {

    // ... your other user routes (dashboard, profile, education, etc.)

    // Add this line for publication management
    Route::resource('publication', PublicationController::class)->except(['show']);
    Route::post('/publications/reorder', [PublicationController::class, 'reorder'])->name('publication.reorder');
});
