<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TokoController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\BussinessController;
use App\Http\Controllers\Api\CreditCashController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\InstituteKasController;
use App\Http\Controllers\Api\ReportController;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

//API route for register new user
Route::post('/register', [AuthController::class, 'register']);//passed
//API route for login user
Route::post('/login', [AuthController::class, 'login']);
Route::get('/forbidden', [AuthController::class, 'forbidden'])->name('forbidden');

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    //API route for get Profile
    Route::post('/payment', [InstituteKasController::class, 'payment']);//passed
    Route::post('/send_otp', [AuthController::class, 'send_otp']);//passed
    Route::post('/verify_otp', [AuthController::class, 'verify_otp']);//passed
    Route::post('/store_product', [ProductController::class, 'store_product']);//passed
    Route::post('/cashout', [InstituteKasController::class, 'cashout']);//passed
    Route::post('/stock_product', [InstituteKasController::class, 'stock_product']);//passed
    Route::post('/update_stock', [ProductController::class, 'update_stock']);//passed
    Route::post('/history_credit', [CreditCashController::class, 'history_credit']);//passed
    Route::post('/store', [CreditCashController::class, 'store']);//passed
    Route::post('/pelanggan', [InstituteKasController::class, 'pelanggan']);//passed
    Route::post('/transactions', [TransactionController::class, 'store']);//passed
    
    Route::get('/profile', [AuthController::class, 'profile']);//passed
    Route::get('/product', [ProductController::class, 'product']);//passed
    Route::get('/category', [CategoryController::class, 'index']);//passed
    Route::get('/channels', [InstituteKasController::class, 'channels']);//passed
    Route::get('/metode_payment', [InstituteKasController::class, 'metode_payment']);//passed
    Route::get('/cashout_category', [InstituteKasController::class, 'cashout_category']);//passed
    
    Route::post('/bussiness', [TokoController::class, 'create']);
    
    Route::post('/get_sale_today', [ReportController::class, 'get_sale_today']);//passed
    // API route for logout user
    Route::post('/logout', [AuthController::class, 'logout']);
});