<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category')->id;

        return [
            'name'      => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($categoryId)],
            'slug'      => ['required', 'string', 'max:255', Rule::unique('categories')->ignore($categoryId)],
            'parent_id' => 'nullable|exists:categories,id',
        ];
    }
}
