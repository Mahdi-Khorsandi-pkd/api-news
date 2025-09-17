<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuItemResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            // اطلاعات از مدل Category گرفته می‌شود
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,

            // اگر زیرمنویی وجود داشت، آن‌ها را هم با همین ریسورس فرمت‌دهی کن
            'children' => $this->when(isset($this->children), function () {
                return MenuItemResource::collection($this->children);
            }),
        ];
    }
}
