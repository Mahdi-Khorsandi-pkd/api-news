<?php

namespace App\Services;

use App\Models\SocialPlatform;
use Illuminate\Database\Eloquent\Collection;

class SocialPlatformService
{
    /**
     * Get all social platforms.
     */
    public function getAllPlatforms(): Collection
    {
        return SocialPlatform::all();
    }
}
