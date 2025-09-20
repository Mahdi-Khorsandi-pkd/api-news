<?php

namespace App\Services;

use App\Models\Setting;
use App\Models\SocialPlatform;
use App\Models\User;
use Illuminate\Support\Collection;

class SettingService
{
    /**
     * Get all settings, grouped by their 'group' key.
     */
    public function getGroupedSettings(): Collection
    {
        // ۱. تمام پلتفرم‌های تعریف شده را می‌خوانیم و برای دسترسی سریع، آنها را بر اساس کلیدشان مرتب می‌کنیم
        $platforms = SocialPlatform::all()->keyBy('key');

        // ۲. تمام تنظیمات را خوانده و بر اساس گروه دسته‌بندی می‌کنیم
        $settings = Setting::all()->groupBy('group');

        // ۳. روی هر گروه از تنظیمات کار می‌کنیم تا خروجی را فرمت‌دهی کنیم
        return $settings->map(function ($group, $groupName) use ($platforms) {

            // ۴. اگر گروه، گروه شبکه‌های اجتماعی بود، منطق خاصی را اجرا می‌کنیم
            if ($groupName === 'social_media') {
                return $group->mapWithKeys(function ($setting) use ($platforms) {
                    if (!$platform = $platforms->get($setting->key)) {
                        return [];
                    }

                    // ساختار جدید را با اطلاعات پلتفرم و لینک تنظیمات می‌سازیم
                    $data = [
                        'url' => $setting->value,
                        'icon' => $platform->icon,
                        'color' => $platform->color,
                        'name' => $platform->name,
                    ];

                    return [$setting->key => $data];
                });
            }

            // ۵. برای بقیه گروه‌ها، همان خروجی ساده قبلی را برمی‌گردانیم
            return $group->pluck('value', 'key');
        });
    }

    /**
     * Get all settings and available social platforms for the admin panel.
     */
    public function getSettingsForPanel(): array
    {
        return [
            'settings' => $this->getGroupedSettings(),
            'platforms' => SocialPlatform::all(),
        ];
    }

    /**
     * Update settings from a given array.
     */
    public function updateSettings(array $settings): void
    {
        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                [
                    'group' => $setting['group'],
                    'key' => $setting['key'],
                ],
                [
                    'value' => $setting['value'],
                ]
            );
        }
    }

    // in SettingService.php
    public function deleteSetting(string $group, string $key): bool
    {
        return Setting::where('group', $group)->where('key', $key)->delete();
    }
}
