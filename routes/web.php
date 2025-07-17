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


use App\Http\Controllers\PaymentController;

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

use App\Http\Controllers\PublicCircularController;
use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\User\ImageManagementController;
use App\Http\Controllers\User\ApplicationHistoryController;

use App\Http\Controllers\SslCommerzPaymentController;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::get('/', [PublicCircularController::class, 'index'])->name('index');
Route::get('/circulars', [PublicCircularController::class, 'index'])->name('circulars.index');
Route::get('/circulars/{circular:circular_no}', [PublicCircularController::class, 'show'])->name('circulars.show');
//  Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');



Route::middleware('auth')->group(function () {
    // --- Personal Information / Profile Routes ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // This route shows the page with password and account deletion forms.
    Route::get('/settings', UserSettingsController::class)->name('profile.settings');

    Route::get('/my-profile/preview', [ProfilePreviewController::class, 'show'])->name('profile.preview');


    // Manages Education records (List, Create, Edit, Delete)
    Route::resource('education', EducationController::class)->except(['show']);
    Route::post('/education/reorder', [EducationController::class, 'reorder'])->name('education.reorder');

    // Manages Work Experience records
    Route::resource('experience', ExperienceController::class)->except(['show']);
    Route::post('/experience/reorder', [ExperienceController::class, 'reorder'])->name('experience.reorder');


    // Manages Language Proficiency records
    Route::resource('language', LanguageController::class)->except(['show']);
    Route::post('/languages/reorder', [LanguageController::class, 'reorder'])->name('language.reorder');

    // Manages Referee records
    Route::resource('referee', RefereeController::class)->except(['show']);
    Route::post('/referees/reorder', [RefereeController::class, 'reorder'])->name('referee.reorder');

    // Manages Training records
    Route::resource('training', TrainingController::class)->except(['show']);
    Route::post('/training/reorder', [TrainingController::class, 'reorder'])->name('training.reorder');


    Route::resource('publication', PublicationController::class)->except(['show']);
    Route::post('/publications/reorder', [PublicationController::class, 'reorder'])->name('publication.reorder');


    Route::resource('award', AwardController::class)->except(['show']);
    Route::post('/awards/reorder', [AwardController::class, 'reorder'])->name('award.reorder');

    // Manages Document records
    Route::resource('document', DocumentController::class)->except(['show']);
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/manage-images', [ImageManagementController::class, 'index'])->name('images.index');
    Route::post('/manage-images', [ImageManagementController::class, 'store'])->name('images.store');
});


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/applications', ApplicationHistoryController::class)->name('applications.history.index');
    Route::delete('/applications/{application}', [JobApplicationController::class, 'destroy'])->name('applications.history.destroy');
    Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');
    // Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    // Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
});







use App\Http\Controllers\Admin\ApplicationManagementController;
use App\Http\Controllers\Admin\CircularController;
use App\Http\Controllers\Admin\JobManagementController;
// ... other use statements

// Route::middleware(['auth', 'verified'])
//     ->prefix('admin')
//     ->name('admin.')
//     ->group(function () {



//  Route::middleware(['can:view-applications'])->group(function () {
//             // This route lists all applications for an entire circular (what you have now)
//             Route::get('/circulars/{circular}/applications', [ApplicationManagementController::class, 'index'])->name('circulars.applications.index');

//             // NEW: This route lists all applications for a SINGLE job post
//             Route::get('/jobs/{job}/applications', [ApplicationManagementController::class, 'showApplicationsForJob'])->name('jobs.applications.index');

//             // This route shows a single application's details
//             Route::get('/applications/{application}', [ApplicationManagementController::class, 'show'])->name('applications.show');
//         });
//         Route::middleware(['can:update-application-status'])->group(function () {
//             // Route to handle the status update form submission
//             Route::put('/applications/{application}/status', [ApplicationManagementController::class, 'updateStatus'])->name('applications.status.update');
//         });
//     });




