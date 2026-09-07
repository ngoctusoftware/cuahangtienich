<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

// Quản lý thông tin chung: logo, tên site, hotline, email, địa chỉ, link Zalo/Messenger...
class SettingController extends Controller
{
    protected array $fields = [
        'site_name' => 'Tên website', 'site_logo' => 'Logo (đường dẫn ảnh)',
        'hotline' => 'Số điện thoại', 'email' => 'Email', 'address' => 'Địa chỉ',
        'working_hours' => 'Giờ làm việc', 'zalo_link' => 'Link Zalo', 'messenger_link' => 'Link Messenger',
    ];

    public function __construct(protected SettingService $settingService)
    {
    }

    public function index(): View
    {
        $values = $this->settingService->all();

        return view('admin.settings.index', ['fields' => $this->fields, 'values' => $values]);
    }

    public function update(Request $request): RedirectResponse
    {
        foreach (array_keys($this->fields) as $key) {
            if ($request->has($key)) {
                $this->settingService->set($key, $request->input($key));
            }
        }

        return back()->with('success', 'Đã cập nhật cấu hình chung.');
    }
}
