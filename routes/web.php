<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\VisitsController;
use App\Http\Controllers\CookieConsentController;

/*
Route::get('/', function () {
    return view('home');
});
*/

// debug
/*
Route::get('/', function () {
    // return redirect('/categories/slug1');
});
*/

Route::get('/{any}', function () {
    return view('home'); 
})->where('any', '.*');
/*
Route::get('/admin/{any}', function () {
    return view('home'); 
})->where('any', '.*');
*/
Route::post('visits', 'App\Http\Controllers\VisitsController@store');

// routes/web.php
Route::post('/cookie-consent', [CookieConsentController::class, 'store'])
    ->name('cookie-consent.store');

Route::get('/cookie-consent', [CookieConsentController::class, 'getConsent'])
    ->name('cookie-consent.get');

// Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    
    Route::post('/cart', [CartController::class, 'viewCart'])->name('cart.view');
    
    Route::put('/cart/update/{cartItem}', [CartController::class, 'updateCart'])->name('cart.update');
    
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'removeFromCart'])->name('cart.remove');


    Route::get('/checkout', [CheckoutController::class, 'showCheckout'])->name('checkout');
    
    Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
    
    Route::post('/checkout/success', [CheckoutController::class, 'checkoutSuccess'])->name('checkout.success');
    
    Route::get('/checkout/cancel', [CheckoutController::class, 'checkoutCancel'])->name('checkout.cancel');
    
    Route::post('/payment/paypal/webhook', [PaymentController::class, 'handlePayPalWebhook']);
    
    Route::post('/payment/stripe/webhook', [PaymentController::class, 'handleStripeWebhook']);
// });