<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DeleteSettingRequest extends FormRequest
{
    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // پارامترهای group و key را از آدرس (route) خوانده و به درخواست اضافه می‌کنیم
        $this->merge([
            'group' => $this->route('group'),
            'key' => $this->route('key'),
        ]);
    }

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'group' => [
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value === 'site_info') {
                        $fail('حذف تنظیمات گروه site_info مجاز نیست.');
                    }
                },
            ],
            'key' => [
                'required',
                'string',
                Rule::exists('settings', 'key')->where('group', $this->route('group'))
            ]
        ];
    }
}
