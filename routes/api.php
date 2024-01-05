<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromoController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VerificationController;
use App\Models\User;
use App\Notifications\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('v1')->group(function(){
    Route::post('register', [AuthController::class, 'register']);    
    Route::post('login', [AuthController::class, 'login']); 
    Route::post('directOtp', [VerificationController::class, 'directOtp']);    
    Route::post('verify', [VerificationController::class, 'verify']);
    Route::post('directSetPassword', [UserController::class, 'directSetPassword']);
    Route::get('pdf/{id}/{token}', [OrderController::class, 'pdf']);
    Route::group(['middleware' => 'auth:sanctum'], function(){
        Route::post('sendOtp', [VerificationController::class, 'sendOtp']); 
        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('products', [ProductController::class, 'index']);
        Route::get('detailProduct/{id}', [ProductController::class, 'show']);
        Route::post('carts', [ProductController::class, 'carts']);
        Route::post('favorites', [ProductController::class, 'favorites']);
        Route::post('checkouts', [OrderController::class, 'checkouts']);
        Route::post('orders', [OrderController::class, 'orders']);
        Route::get('orders', [OrderController::class, 'index']);
        Route::get('promos', [PromoController::class, 'index']);
        Route::get('orders/{id}', [OrderController::class, 'show']);
        Route::post('users', [UserController::class, 'update']);
        Route::post('changePassword', [UserController::class, 'changePassword']);
        Route::get('notif', [NotificationController::class, 'index']);
        Route::post('notif', [NotificationController::class, 'update']);
    });   
});
