<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Database\Eloquent\Collection;

class MenuService
{
    /**
     * Get all menus defined in the system.
     */
    public function getAllMenus(): Collection
    {
        return Menu::all();
    }

    /**
     * Get a menu by its location and build a hierarchical tree of its items.
     */
    public function getMenuByLocation(string $location): ?array
    {
        $menu = Menu::where('location', $location)->with('categories')->first();

        if (!$menu) {
            return null;
        }

        $menuItems = $menu->categories;

        return $this->buildTree($menuItems);
    }

    /**
     * A recursive helper function to build a tree structure from a flat collection.
     */
    private function buildTree(Collection $elements, $parentId = null): array
    {
        $branch = [];

        foreach ($elements as $element) {
            // pivot->parent_id is the key to building the hierarchy
            if ($element->pivot->parent_id == $parentId) {
                $children = $this->buildTree($elements, $element->pivot->id);

                if ($children) {
                    $element->children = $children;
                }

                $branch[] = $element;
            }
        }

        return $branch;
    }

    // متد sync را در مراحل بعدی پیاده‌سازی خواهیم کرد
    public function syncMenu(Menu $menu, array $items): void
    {
        // Logic to parse the items array and sync with the pivot table
    }
}
