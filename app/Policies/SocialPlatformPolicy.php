<?php

namespace App\Policies;

use App\Models\SocialPlatform;
use App\Models\User;

class SocialPlatformPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin');
    }
}
