<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

// Cache toàn bộ settings (logo, hotline, địa chỉ...) bằng Redis để không query DB mỗi request
class SettingService
{
    public function all(): array
    {
        return Cache::rememberForever('settings:all', function () {
            return Setting::pluck('value', 'key')->toArray();
        });
    }

    public function get(string $key, $default = null)
    {
        return $this->all()[$key] ?? $default;
    }

    public function set(string $key, $value): void
    {
        Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget('settings:all');
    }
}
