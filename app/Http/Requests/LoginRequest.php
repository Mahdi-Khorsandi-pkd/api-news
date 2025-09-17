<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    // ... متد authorize

    public function rules(): array
    {
        return [
            'username' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'nullable|boolean', // <-- این خط اضافه شود
        ];
    }
}
