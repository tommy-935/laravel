<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('visits', 'App\Http\Controllers\VisitsController@index');
Route::get('visits/{visit}', 'App\Http\Controllers\VisitsController@show');
Route::put('visits/{visit}', 'App\Http\Controllers\VisitsController@update');
Route::delete('visits/{visit}', 'App\Http\Controllers\VisitsController@destroy');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('categories/{slug}', 'App\Http\Controllers\ProductController@getList');
Route::get('products/{slug}', 'App\Http\Controllers\ProductController@get');

Route::post('/create-payment-intent', [StripePaymentController::class, 'createPaymentIntent']);

Route::post('verify/license', 'App\Http\Controllers\Api\LicenseController@verify');


Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route::post('/categories', [CategoryController::class, 'addToCart'])->name('cart.add');
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);

    Route::post('/attachments', [AttachmentController::class, 'store']);

});


