<?php

use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\LanguageController;
use App\Http\Controllers\Shop\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| SHOP ROUTES (Website bán hàng)
|--------------------------------------------------------------------------
| Routes cho phần Admin nằm ở routes/admin.php (Phase 3), dùng prefix "admin"
| và middleware "auth" + "role:xxx" riêng.
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/ngon-ngu/{code}', [LanguageController::class, 'switch'])->name('lang.switch');

// Sản phẩm & danh mục
Route::get('/san-pham-moi', [ProductController::class, 'newest'])->name('products.newest');
Route::get('/ban-chay', [ProductController::class, 'bestseller'])->name('products.bestseller');
Route::get('/danh-muc/{slug}', [ProductController::class, 'byCategory'])->name('products.byCategory');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('products.show');

// Giỏ hàng
Route::prefix('gio-hang')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/them', [CartController::class, 'add'])->name('add');
    Route::post('/cap-nhat', [CartController::class, 'update'])->name('update');
    Route::post('/xoa', [CartController::class, 'remove'])->name('remove');
});

// Thanh toán
Route::prefix('thanh-toan')->name('checkout.')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
    Route::get('/thanh-cong/{code}', [CheckoutController::class, 'success'])->name('success');
});

// Đăng nhập / đăng ký khách hàng (guard "customer")
Route::prefix('tai-khoan')->name('customer.')->group(function () {
    Route::get('/dang-nhap', [CustomerAuthController::class, 'showLogin'])->name('login');
    Route::post('/dang-nhap', [CustomerAuthController::class, 'login'])->name('login.post');
    Route::get('/dang-ky', [CustomerAuthController::class, 'showRegister'])->name('register');
    Route::post('/dang-ky', [CustomerAuthController::class, 'register'])->name('register.post');
    Route::post('/dang-xuat', [CustomerAuthController::class, 'logout'])->name('logout');

    Route::middleware('auth:customer')->group(function () {
        Route::get('/don-hang', [CustomerAuthController::class, 'orders'])->name('orders');
    });
});

// Trang nội dung tĩnh (giới thiệu, liên hệ, chính sách...) lấy từ bảng "contents"
Route::get('/trang/{key}', [\App\Http\Controllers\Shop\PageController::class, 'show'])->name('page.show');
