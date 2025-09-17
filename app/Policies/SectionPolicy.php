<?php

namespace App\Policies;

use App\Models\Section;
use App\Models\User;

class SectionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Section $section): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether the user can sync categories to the model.
     */
    public function syncCategories(User $user, Section $section): bool
    {
        return $user->hasRole('Admin');
    }
}
