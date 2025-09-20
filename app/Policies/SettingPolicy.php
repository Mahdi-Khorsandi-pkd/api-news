<?php

namespace App\Policies;

use App\Models\Setting;
use App\Models\User;

class SettingPolicy
{
    /**
     * Determine whether the user can view the settings in admin panel.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin');
    }


    /**
     * Determine whether the user can update the settings.
     */
    public function update(User $user): bool
    {
        return $user->hasRole('Admin');
    }


    // in SettingPolicy.php
    public function delete(User $user): bool
    {
        return $user->hasRole('Admin');
    }
}
