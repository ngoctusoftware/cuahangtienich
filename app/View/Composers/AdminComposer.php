<?php

namespace App\View\Composers;

use App\Models\Order;
use App\Services\SettingService;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

// Bơm dữ liệu dùng chung (tên site, logo, số đơn hàng đang chờ...) cho layout
// Admin, lấy trực tiếp từ bảng settings (đã được cache trong SettingService) để
// trang "Quản lý thông tin chung" cập nhật là toàn bộ trang Admin đổi theo.
class AdminComposer
{
    public function __construct(protected SettingService $settingService)
    {
    }

    public function compose(View $view): void
    {
        $settings = $this->settingService->all();

        $view->with([
            'siteName' => $settings['site_name'] ?? 'ZEK SHOP',
            'siteLogo' => $settings['site_logo'] ?? null,
            'sidebarPendingOrders' => Cache::remember('admin:pending_orders_count', 60, function () {
                return Order::where('status', 'pending')->count();
            }),
        ]);
    }
}
