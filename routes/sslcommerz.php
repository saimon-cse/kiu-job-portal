<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;



Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/payment/pay/{application}', [PaymentController::class, 'pay'])->name('payment.pay');
});


// Route::post( '/payment/success', [PaymentController::class, 'success'])->name('payment.success');

Route::get('/payment/success', [PaymentController::class, 'successPage'])->name('payment.success.page');


Route::post('/payment/success', [PaymentController::class, 'success'])->name('payment.success.webhook');

// Route::post('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
Route::post('/payment/fail', [PaymentController::class, 'fail'])->name('payment.fail');
Route::post('/payment/cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');
Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');
Route::post('/pay-via-ajax', [PaymentController::class, 'payViaAjax'])->name('payment.ajax');




// // SSLCOMMERZ Start
// Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
// Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

// Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
// Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

// Route::post('/success', [SslCommerzPaymentController::class, 'success']);
// Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
// Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

// Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END
