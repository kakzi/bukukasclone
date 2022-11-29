<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\CategoryCashOutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MetodePayment;
use App\Http\Controllers\WhatsAppController;

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
    return view('auth.login');
});
Route::get('/forbidden', [AuthController::class, 'forbidden'])->name('forbidden');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {

    // Route::get('/dashboard', function () {
    //     return view('dashboard');
    // })->name('dashboard');

    Route::resource('/category', CategoryController::class);
    Route::resource('/whatsapp', WhatsAppController::class);
    Route::resource('/metode_payment', MetodePayment::class);
    Route::resource('/channel', ChannelController::class);
    Route::resource('/cashout', CategoryCashOutController::class);
    // Route::resource('/tag', 'TagsController');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // More routes here
    
});


//group route with prefix "admin"
// Route::prefix('admin')->group(function () {

//     //group route with middleware "auth"
//     Route::group(['middleware' => 'auth'], function () {

//         //route dashboard
//         Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

//         //route resource categories
//         Route::get('/transaction/done', [TransactionController::class, 'done'])->name('finish');
//         Route::resource('/transaction', TransactionController::class, ['as' => 'admin']);

//         Route::get('/transaction/batal/{id}', [TransactionController::class, 'batal'])->name('transactionBatal');
//         Route::get('/transaction/details/{id}', [TransactionController::class, 'details'])->name('transactionDetail');
//         Route::get('/transaction/faktur/{id}', [TransactionController::class, 'cetak_faktur'])->name('cetak_faktur');
//         Route::get('/transaction/confim/{id}',  [TransactionController::class, 'confirm'])->name('transactionConfirm');
//         Route::get('/transaction/kirim/{id}',  [TransactionController::class, 'kirim'])->name('transactionKirim');
//         Route::get('/transaction/selesai/{id}',  [TransactionController::class, 'selesai'])->name('transactionSelesai');


//         Route::get('/product/download_template',  [ProductController::class, 'downloadTemplate'])->name('download_template');
//         Route::get('/product/import',  [ProductController::class, 'import'])->name('import');
//         Route::post('/product/import_file',  [ProductController::class, 'import_file'])->name('import_file');

//         Route::get('/product/import_update',  [ProductController::class, 'import_update'])->name('import_update');
//         Route::post('/product/imported',  [ProductController::class, 'imported'])->name('imported');
//         Route::get('/report/wakaf',  [ReportController::class, 'wakaf'])->name('searchWakaf');
//         Route::get('/report/downloadwakaf',  [ReportController::class, 'downloadwakaf'])->name('downloadWakaf');

//         Route::resource('/promo', PromoController::class, ['as' => 'admin']);
//         Route::resource('/product', ProductController::class, ['as' => 'admin']);
//         Route::resource('/voucher', VoucherController::class, ['as' => 'admin']);
//         Route::resource('/bank', BankController::class, ['as' => 'admin']);
//         Route::resource('/service', ServiceController::class, ['as' => 'admin']);
//         Route::resource('/report', ReportController::class, ['as' => 'admin']);


//         Route::get('/category/import_category',  [CategoryController::class, 'import_category'])->name('import_category');
//         Route::post('/category/import_file_category',  [CategoryController::class, 'import_file_category'])->name('import_file_category');

//         Route::resource('/category', CategoryController::class, ['as' => 'admin']);

//         Route::get('/customer/export_customer',  [CustomerController::class, 'export_customer'])->name('export_customer');
//         Route::resource('/customer', CustomerController::class, ['as' => 'admin']);

//         Route::resource('/promo', PromoController::class, ['as' => 'admin']);

//         Route::resource('/slide', SlideController::class, ['as' => 'admin']);
//     });
// });
