<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RolesController;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

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
// Route::post('/login', [AuthController::class, 'login']);

Route::middleware([
    EncryptCookies::class,
    StartSession::class,
  //  'throttle:api', // 暂时不需要限制API访问频率
    AddQueuedCookiesToResponse::class,
])->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
});

Route::get('categories/{slug}', 'App\Http\Controllers\ProductController@getList');
Route::get('products/{slug}', 'App\Http\Controllers\ProductController@get');

Route::post('/create-payment-intent', [StripePaymentController::class, 'createPaymentIntent']);

Route::post('verify/license', 'App\Http\Controllers\Api\LicenseController@verify');

Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('/reset-password', [ResetPasswordController::class, 'reset']);

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Route::post('/categories', [CategoryController::class, 'addToCart'])->name('cart.add');
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('users', UsersController::class);
    Route::apiResource('roles', RolesController::class);

    Route::post('/attachments', [AttachmentController::class, 'store']);

});


