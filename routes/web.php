<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RevenueExpenditureController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\testApi;
use App\Models\RevenueExpenditure;
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

Route::middleware('process.payment')->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('nganluong_b8e4cb3ccc25289973ac5e189a326676.html', [App\Http\Controllers\HomeController::class, 'auth']);
    Route::prefix('fetch')->group(function () {
        Route::middleware('auth')->group(function () {
            Route::post('lay-thong-tin-mua-hang', [App\Http\Controllers\ProductController::class, 'fetchBuy'])->name('fetch-buy');
        });
    });
    Route::prefix('process')->group(function () {
        Route::middleware('auth')->group(function () {
            Route::post('thanh-toan', [App\Http\Controllers\ProductController::class, 'checkout'])->name('process.buy-now');
            Route::post('nhan-nhiem-vu', [App\Http\Controllers\ProductController::class, 'talkingMission'])->name('process.taking-mission');
            Route::post('da-xem-thong-bao-{id}', [App\Http\Controllers\ProductController::class, 'daXem'])->name('process.da-xem-thong-bao');
        });
    });
    Route::prefix('account')->group(function () {
        Route::middleware('guest')->group(function () {
            Route::get('/login', [App\Http\Controllers\AccountController::class, 'login'])->name('login');
            Route::post('/process-login', [App\Http\Controllers\AccountController::class, 'processLogin'])->name('process-login');
            Route::get('/register', [App\Http\Controllers\AccountController::class, 'register'])->name('register');
            Route::post('/process-register', [App\Http\Controllers\AccountController::class, 'processReg'])->name('process-register');
            Route::get('/forgot', [App\Http\Controllers\AccountController::class, 'forgot'])->name('forgot');
            Route::post('/forgot', [App\Http\Controllers\AccountController::class, 'forgotPass'])->name('forgot-password');
        });

        Route::middleware('auth')->group(function () {
            Route::get('/logout', [App\Http\Controllers\AccountController::class, 'logout'])->name('logout');
            Route::get('/profile', [App\Http\Controllers\AccountController::class, 'index'])->name('profile');
            Route::get('/don-hang', [App\Http\Controllers\AccountController::class, 'orders'])->name('orders');
            Route::get('/lich-su-nap-tien', [App\Http\Controllers\AccountController::class, 'history'])->name('history');
            Route::post('/xac-thuc-email', [App\Http\Controllers\AccountController::class, 'verifyMail'])->name('verify-email');
            Route::post('/cap-nhat-thong-tin-ca-nhan', [App\Http\Controllers\AccountController::class, 'updateProfile'])->name('update-profile');
            Route::post('/cap-nhat-mat-khau', [App\Http\Controllers\AccountController::class, 'updatePass'])->name('update-password');
            Route::post('/process-bank', [App\Http\Controllers\AccountController::class, 'processBank'])->name('process-bank');
            Route::get('/thong-tin-chuyen-khoan-ma-hoa-don-{id}', [App\Http\Controllers\AccountController::class, 'bankInfo'])->name('bank-info');
            Route::get('/cong-tac-vien', [App\Http\Controllers\AccountController::class, 'affilate'])->name('affilate');
            Route::get('ho-tro-don-hang-{id}', [App\Http\Controllers\AccountController::class, 'supportOrder'])->name('report-order');
        });
    });
    Route::prefix('staff')->middleware('auth')->group(function () {
        Route::post('add-mission', [App\Http\Controllers\StaffController::class, 'addMission'])->name('staff.add-mission');
        Route::post('them-gian-hang', [App\Http\Controllers\StaffController::class, 'addGianHang'])->name('staff.add-gian-hang');
        Route::post('them-san-pham', [App\Http\Controllers\StaffController::class, 'addSanPham'])->name('staff.add-product');
        Route::post('process-product', [App\Http\Controllers\StaffController::class, 'processCookieDie'])->name('staff.cookie-die');
        Route::post('fetch-gian-hang', [App\Http\Controllers\StaffController::class, 'fetchGianHang'])->name('staff.fetch-gian-hang');
        Route::get('process-edit', [App\Http\Controllers\StaffController::class, 'processGianHang'])->name('staff.process-edit');
        Route::get('quan-tri-nhanh', [App\Http\Controllers\StaffController::class, 'index'])->name('staff.index');
        Route::get('quan-tri-thong-bao', [App\Http\Controllers\StaffController::class, 'notify'])->name('staff.notify');
        Route::post('them-thong-bao', [App\Http\Controllers\StaffController::class, 'processNotify'])->name('staff.them-thong-bao');
        Route::post('get-notify', [App\Http\Controllers\StaffController::class, 'getNotify'])->name('staff.get-notify');
        Route::post('change-status-notify', [App\Http\Controllers\StaffController::class, 'changeStatusNotify'])->name('staff.change-notify-status');
        Route::get('cap-nhat-trang-thai', [App\Http\Controllers\StaffController::class, 'scan'])->name('staff.status-order-scan');
        Route::get('cap-nhat-thong-tin-ck', [App\Http\Controllers\StaffController::class, 'bankingCheck'])->name('staff.banking-status');
    });
    Route::get('/nhiem-vu', [App\Http\Controllers\ProductController::class, 'mission'])->name('mission');
    Route::get('/cau-hoi-thuong-gap', [App\Http\Controllers\ProductController::class, 'faq'])->name('faq');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware'=> ['auth','admin'],
], function () {
    // order
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('orders', [OrderController::class, 'index'])->name('orders');
    Route::get('products', [ProductController::class, 'index'])->name('products');
    Route::get('products/add', [ProductController::class, 'add'])->name('products.add');
    Route::post('products/add', [ProductController::class, 'create']);
    Route::get('products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('products/edit/{id}', [ProductController::class, 'update']);
    Route::delete('products/delete/{id}', [ProductController::class, 'delete'])->name('products.delete');
    Route::get('products/{id}', [ProductController::class, 'detail'])->name('products.detail');

    // user
    Route::resource('users', UserController::class);
    Route::post('users/update-waller/{id}', [UserController::class, 'updateWaller'])->name('users.update-waller');

    // treasury
    Route::resource('/treasury', RevenueExpenditureController::class);

    Route::get('/reset-cookie', [CookieController::class, 'resetCookie'])->name('reset-cookie');

});

Route::get('/test', [testApi::class, 'index']);
