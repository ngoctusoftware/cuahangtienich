<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Shop\CartController;
use App\Http\Controllers\Shop\CheckoutController;
use App\Http\Controllers\Shop\HomeController;
use App\Http\Controllers\Shop\OrderController;
use App\Http\Controllers\Shop\PaymentController;
use App\Http\Controllers\Shop\ProductController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WEBSITE BAN HANG (khach hang)
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('shop.home');

Route::get('/san-pham', [ProductController::class, 'index'])->name('products.index');
Route::get('/san-pham/{slug}', [ProductController::class, 'show'])->name('products.show');

Route::get('/gio-hang', [CartController::class, 'index'])->name('cart.index');
Route::post('/gio-hang/them/{product}', [CartController::class, 'add'])->name('cart.add');
Route::patch('/gio-hang/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/gio-hang/{product}', [CartController::class, 'remove'])->name('cart.remove');

// Xac thuc khach hang
Route::get('/dang-ky', [RegisterController::class, 'showForm'])->name('register')->middleware('guest');
Route::post('/dang-ky', [RegisterController::class, 'register'])->middleware('guest');
Route::get('/dang-nhap', [LoginController::class, 'showForm'])->name('login')->middleware('guest');
Route::post('/dang-nhap', [LoginController::class, 'login'])->middleware('guest');
Route::post('/dang-xuat', [LoginController::class, 'logout'])->name('logout');

// Dat hang / thanh toan - can dang nhap
Route::middleware('auth')->group(function () {
    Route::get('/thanh-toan', [CheckoutController::class, 'show'])->name('cart.checkout');
    Route::post('/thanh-toan', [CheckoutController::class, 'placeOrder'])->name('checkout.place');
    Route::get('/don-hang', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/don-hang/{code}', [OrderController::class, 'show'])->name('orders.show');
});

Route::get('/don-hang/{code}/thanh-cong', [CheckoutController::class, 'success'])->name('orders.success');

// Cong thanh toan tu dong
Route::get('/payment/{code}/process', [PaymentController::class, 'process'])->name('payment.process');
Route::get('/payment/demo/{code}', [PaymentController::class, 'showDemoGateway'])->name('payment.demo.show');
Route::post('/payment/demo/{code}', [PaymentController::class, 'confirmDemoGateway'])->name('payment.demo.confirm');
Route::get('/payment/vnpay/return', [PaymentController::class, 'vnpayReturn'])->name('payment.vnpay.return');

/*
|--------------------------------------------------------------------------
| TRANG QUAN TRI (Admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // 1. Quan ly nguoi dung
    Route::resource('users', UserController::class);

    // 2. Quan ly phan quyen
    Route::resource('roles', RoleController::class);

    // 3. Quan ly san pham (+ danh muc)
    Route::resource('products', AdminProductController::class)->middleware('permission:products.manage');
    Route::resource('categories', AdminCategoryController::class)->middleware('permission:products.manage');

    // 4. Quan ly don hang
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index')->middleware('permission:orders.manage');
    Route::get('orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show')->middleware('permission:orders.manage');
    Route::patch('orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus')->middleware('permission:orders.manage');

    // 5. Quan ly thanh toan
    Route::get('payments', [AdminPaymentController::class, 'index'])->name('payments.index')->middleware('permission:payments.manage');
    Route::patch('payments/{payment}/mark-paid', [AdminPaymentController::class, 'markPaid'])->name('payments.markPaid')->middleware('permission:payments.manage');
});
