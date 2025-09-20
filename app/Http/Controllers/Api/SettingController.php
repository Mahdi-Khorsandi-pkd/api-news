<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteSettingRequest;
use App\Http\Requests\UpdateSettingsRequest;
use App\Http\Resources\SocialPlatformResource; // <-- ۱. ریسورس را اضافه کن
use App\Models\Setting;
use App\Services\SettingService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class SettingController extends Controller
{
    use ApiResponse;

    protected SettingService $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    public function index(): JsonResponse
    {
        $settings = $this->settingService->getGroupedSettings();
        return $this->successResponse($settings, 'اطلاعات تنظیمات با موفقیت دریافت شد.');
    }

    public function getAllForSettingsPanel(): JsonResponse
    {
        $this->authorize('viewAny', Setting::class);
        $data = $this->settingService->getSettingsForPanel();

        // ۲. خروجی را با استفاده از ریسورس فرمت‌دهی کن
        $formattedData = [
            'settings' => $data['settings'],
            'platforms' => SocialPlatformResource::collection($data['platforms']),
        ];

        return $this->successResponse($formattedData, 'اطلاعات تنظیمات با موفقیت دریافت شد.');
    }

    public function update(UpdateSettingsRequest $request): JsonResponse
    {
        $this->authorize('update', Setting::class);
        $this->settingService->updateSettings($request->validated()['settings']);
        return $this->successResponse(null, 'تنظیمات با موفقیت ویرایش شد.');
    }


    public function destroy(DeleteSettingRequest $request, string $group, string $key): JsonResponse
    {
        // اعتبارسنجی به صورت خودکار توسط DeleteSettingRequest انجام شده است.
        $this->authorize('delete', Setting::class);

        $this->settingService->deleteSetting($group, $key);

        return $this->successResponse(null, 'تنظیمات با موفقیت حذف شد.');
    }
}
