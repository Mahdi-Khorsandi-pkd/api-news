<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;

class MenuPolicy
{
    /**
     * Determine whether the user can view the list of menus (for admin panel).
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('Admin');
    }

    /**
     * Determine whether anyone can view a specific menu (public endpoint).
     */
    public function view(?User $user, Menu $menu): bool
    {
        // چون این مسیر عمومی است، همیشه true برمی‌گردانیم
        return true;
    }

    /**
     * Determine whether the user can sync items to the menu.
     */
    public function sync(User $user, Menu $menu): bool
    {
        return $user->hasRole('Admin');
    }
}
