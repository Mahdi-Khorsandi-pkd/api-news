<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // چون دسترسی رو در فایل Route کنترل کردیم
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255|unique:categories,name',
            'slug'      => 'required|string|max:255|unique:categories,slug',
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }
}
