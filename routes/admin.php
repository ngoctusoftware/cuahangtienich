<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\CustomerGroupController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AdminAuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
| Đăng nhập dùng guard mặc định "web" (App\Models\User).
| Toàn bộ route quản trị đặt trong prefix/name "admin.", bảo vệ bởi middleware
| "auth" (bắt buộc đăng nhập); các thao tác nhạy cảm bọc thêm "permission:xxx".
*/

Route::prefix('admin')->name('admin.')->group(function () {

    // Đăng nhập / đăng xuất Admin (không cần middleware auth)
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

    Route::middleware('auth')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Hồ sơ cá nhân của người đang đăng nhập (mọi vai trò đều xem/sửa được của chính mình)
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

        // Cấu hình chung
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index')->middleware('permission:settings.view');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update')->middleware('permission:settings.update');

        // Nội dung (CMS)
        Route::resource('contents', ContentController::class)->except(['show'])
            ->middleware('permission:contents.view');

        // Ngôn ngữ
        Route::resource('languages', LanguageController::class)->except(['show'])
            ->middleware('permission:languages.view');

        // Danh mục
        Route::resource('categories', CategoryController::class)->except(['show'])
            ->middleware('permission:categories.view');

        // Sản phẩm
        Route::resource('products', ProductController::class)->except(['show'])
            ->middleware('permission:products.view');

        // Đơn hàng
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index')->middleware('permission:orders.view');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show')->middleware('permission:orders.view');
        Route::put('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus')->middleware('permission:orders.update');

        // Thanh toán
        Route::get('payments', [PaymentController::class, 'index'])->name('payments.index')->middleware('permission:payments.view');
        Route::put('payments/{payment}/status', [PaymentController::class, 'updateStatus'])->name('payments.updateStatus')->middleware('permission:payments.update');

        // Nhóm khách hàng & khách hàng
        Route::resource('customer-groups', CustomerGroupController::class)->except(['show'])
            ->middleware('permission:customers.view');
        Route::resource('customers', CustomerController::class)->except(['show'])
            ->middleware('permission:customers.view');

        // Người dùng & phân quyền
        Route::resource('users', UserController::class)->except(['show'])
            ->middleware('permission:users.view');
        Route::resource('roles', RoleController::class)->except(['show'])
            ->middleware('permission:users.view');
    });
});
