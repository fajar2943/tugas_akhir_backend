<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VariantController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});
Route::get('login', function () {
    return (isRole('Admin')) ? redirect('/dashboard') : view('auth.login');
});
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth', 'CheckRoles:Superadmin']], function () {
    Route::get('form', [UserController::class, 'form']);
});
Route::group(['middleware' => ['auth', 'CheckRoles:Admin,Superadmin']], function () {
    Route::group(['prefix' => 'dashboard'], function() {
        Route::get('', [DashboardController::class, 'index']);
    });
    Route::group(['prefix' => 'categories'], function() {
        Route::get('', [CategoryController::class, 'index']);
        Route::get('data', [CategoryController::class, 'data']);
        Route::get('form', [CategoryController::class, 'form']);
        Route::get('form/{categories}', [CategoryController::class, 'form']);
        Route::post('save', [CategoryController::class, 'save']);
        Route::get('delete/{id}', [CategoryController::class, 'delete']);
        Route::group(['prefix' => '{id_categories}/product'], function() {
            Route::get('', [ProductController::class, 'index']);
            Route::get('data', [ProductController::class, 'data']);
            Route::get('form', [ProductController::class, 'form']);
            Route::get('form/{product}', [ProductController::class, 'form']);
            Route::post('save', [ProductController::class, 'save']);
            Route::get('delete/{id}', [ProductController::class, 'delete']);
            
            Route::group(['prefix' => '{id_product}/variant'], function() {
                Route::get('', [VariantController::class, 'index']);
                Route::get('data', [VariantController::class, 'data']);
                Route::get('form', [VariantController::class, 'form']);
                Route::get('form/{variant}', [VariantController::class, 'form']);
                Route::post('save', [VariantController::class, 'save']);
                Route::get('delete/{id}', [VariantController::class, 'delete']);
    
            });
        });
    });
    // Profile & ChangePassword
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/changepassword', [ProfileController::class, 'changePassword']);

    Route::group(['prefix' => 'user'], function() {
        Route::get('', [UserController::class, 'index']);
        Route::get('data', [UserController::class, 'data']);
        Route::post('save', [UserController::class, 'save']);
        Route::get('banned/{id}', [UserController::class, 'banned']);
        Route::get('unbanned/{id}', [UserController::class, 'unbanned']);
    });
    Route::group(['prefix' => 'discount'], function() {
        Route::get('', [DiscountController::class, 'index']);
        Route::get('data', [DiscountController::class, 'data']);
        Route::get('form', [DiscountController::class, 'form']);
        Route::get('form/{discount}', [DiscountController::class, 'form']);
        Route::post('save', [DiscountController::class, 'save']);
        Route::get('delete/{id}', [DiscountController::class, 'delete']);

    });
    Route::group(['prefix' => 'promo'], function() {
        Route::get('', [PromoController::class, 'index']);
        Route::get('data', [PromoController::class, 'data']);
        Route::get('form', [PromoController::class, 'form']);
        Route::get('form/{promo}', [PromoController::class, 'form']);
        Route::post('save', [PromoController::class, 'save']);
        Route::get('delete/{id}', [PromoController::class, 'delete']);

    });
    Route::group(['prefix' => 'order'], function() {
        Route::get('', [OrderController::class, 'index']);
        Route::get('data', [OrderController::class, 'data']);
        Route::get('form', [OrderController::class, 'form']);
        Route::get('form/{order}', [OrderController::class, 'form']);
        Route::post('save', [OrderController::class, 'save']);
        Route::get('delete/{id}', [OrderController::class, 'delete']);
        Route::group(['prefix' => 'done_order'], function() {
            Route::get('', [OrderController::class, 'done_order']);
            Route::get('data', [OrderController::class, 'done_order_data']);
        });
        Route::get('/cetak-laporan', [OrderController::class, 'cetakLaporan']);

    });
    Route::get('logout', [AuthController::class, 'logout']);
});
