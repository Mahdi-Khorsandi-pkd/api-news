<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SyncMenuRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items' => 'required|array',
            'items.*.category_id' => 'required|integer|exists:categories,id',
            'items.*.order' => 'required|integer',
            'items.*.children' => 'present|array',

            // اعتبارسنجی برای سطح دوم زیرمنوها
            'items.*.children.*.category_id' => 'required|integer|exists:categories,id',
            'items.*.children.*.order' => 'required|integer',
            'items.*.children.*.children' => 'present|array',
        ];
    }
}
