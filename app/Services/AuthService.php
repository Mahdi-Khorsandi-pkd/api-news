<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Arr;

class AuthService
{
    /**
     * Attempt to log the user in and return a token.
     *
     * @throws AuthenticationException
     */
    public function login(array $data): array
    {
        $credentials = Arr::except($data, 'remember_me');
        $rememberMe = Arr::get($data, 'remember_me', false);

        if (!Auth::attempt($credentials)) {
            throw new AuthenticationException(__('auth.failed'));
        }

        /** @var User $user */
        $user = Auth::user();

        // ۱. مدیریت محدودیت تعداد توکن‌ها
        if ($user->tokens()->count() >= 2) {
            // قدیمی‌ترین توکن را پیدا کرده و حذف کن
            $user->tokens()->orderBy('created_at', 'asc')->first()->delete();
        }

        // ۲. ساخت آبجکت توکن جدید
        $newAccessToken = $user->createToken('api-token');

        // ۳. دسترسی به مدل توکن برای تغییر تاریخ انقضا
        $token = $newAccessToken->accessToken;

        // ۴. تنظیم تاریخ انقضا بر اساس ورودی
        if ($rememberMe) {
            $token->expires_at = now()->addDays(30);
        } else {
            $token->expires_at = now()->addHours(1);
        }

        // ۵. ذخیره تغییرات
        $token->save();

        return [
            'user' => $user,
            'access_token' => $newAccessToken->plainTextToken,
        ];
    }
}
