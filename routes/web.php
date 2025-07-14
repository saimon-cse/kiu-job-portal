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

use App\Http\Controllers\PublicCircularController;
use App\Http\Controllers\JobApplicationController;
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [PublicCircularController::class, 'index'])->name('index');
Route::get('/circulars', [PublicCircularController::class, 'index'])->name('circulars.index');
Route::get('/circulars/{circular:circular_no}', [PublicCircularController::class, 'show'])->name('circulars.show');
//  Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');

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


use App\Http\Controllers\User\ImageManagementController;


Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/manage-images', [ImageManagementController::class, 'index'])->name('images.index');
    Route::post('/manage-images', [ImageManagementController::class, 'store'])->name('images.store');
});



Route::middleware(['auth', 'verified'])->group(function () {
    Route::resource('publication', PublicationController::class)->except(['show']);
    Route::post('/publications/reorder', [PublicationController::class, 'reorder'])->name('publication.reorder');
});


use App\Http\Controllers\PaymentController;
// ...

// Routes for authenticated users
// Route::middleware(['auth', 'verified'])->group(function () {
//     // ...
//     Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
//     Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
// });

// // Routes for payment gateway callbacks (these must be outside CSRF protection)
// Route::post('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
// Route::post('/payment/failure', [PaymentController::class, 'failure'])->name('payment.failure');
// Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn'); // Instant Payment Notification


use App\Http\Controllers\User\ApplicationHistoryController;
// ... (other use statements)

Route::middleware(['auth', 'verified'])->group(function () {

    // ... (dashboard, profile, and all other user routes) ...

Route::get('/my-applications', ApplicationHistoryController::class)->name('applications.history.index');
    // The 'jobs.apply' route and payment routes remain the same
    Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');
    // Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
    // Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
});



// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::post('/payment/pay/{application}', [PaymentController::class, 'pay'])->name('payment.pay');
// });

// use App\Http\Controllers\PaymentController;

// This route must be accessible to logged-in users to start the payment

// This route must be accessible to logged-in users to start the payment
Route::middleware(['auth', 'verified'])->group(function () {
    // Correctly pass the {application} which is an ApplicationHistory instance
    Route::get('/payment/pay/{application}', [PaymentController::class, 'pay'])->name('payment.pay');
});

// Route::get('/success', function(){
//     return view('payment.success');
// });
// It can be named anything, e.g., 'payment.return' or 'payment.thankyou'.
Route::get('/success', [PaymentController::class, 'success'])->name('payment.success');

// 2. The routes the SSLCOMMERZ SERVER will POST to. These handle the logic.
// They MUST be outside any auth middleware and CSRF protection.
// Route::post('/payment/success', [PaymentController::class, 'success'])->name('payment.success.webhook');

// These callback routes MUST be outside any auth middleware and CSRF protection.
// Route::post('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::post('/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
Route::post('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');
Route::post('/pay-via-ajax', [App\Http\Controllers\PaymentController::class, 'payViaAjax'])->name('payment.ajax');
use App\Http\Controllers\SslCommerzPaymentController;


// // SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

// Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
// Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

// Route::post('/success', [SslCommerzPaymentController::class, 'success']);
// Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
// Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

// Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END
