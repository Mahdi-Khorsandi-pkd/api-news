<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'username' => $this->username,
            'email' => $this->email,
            'status' => $this->status,
            'roles' => $this->getRoleNames(), // <-- اضافه کردن نام نقش‌ها
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
