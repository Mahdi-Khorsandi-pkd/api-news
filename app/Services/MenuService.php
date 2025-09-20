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
        // کوئری را اصلاح می‌کنیم تا اطلاعات pivot را به درستی لود کند
        $menu = Menu::where('location', $location)
        ->with(['categories' => function ($query) {
            $query->orderBy('pivot_order', 'asc');
        }])
        ->first();

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

     /**
     * Sync the menu items with the given hierarchical structure.
     */
    public function syncMenu(Menu $menu, array $items): void
    {
        // ۱. تمام آیتم‌های قبلی این منو را حذف می‌کنیم تا از نو بسازیم
        $menu->categories()->detach();

        // ۲. فرآیند بازگشتی ذخیره آیتم‌های جدید را شروع می‌کنیم
        $this->saveMenuItems($menu, $items);
    }

    /**
     * A recursive helper function to save menu items and their children.
     */
    private function saveMenuItems(Menu $menu, array $items, $parentId = null): void
    {
        foreach ($items as $itemData) {
            // ۳. آیتم فعلی را به منو متصل می‌کنیم و اطلاعات pivot را ذخیره می‌کنیم
            $menu->categories()->attach($itemData['category_id'], [
                'parent_id' => $parentId,
                'order' => $itemData['order'],
            ]);

            // ۴. اگر آیتم فعلی فرزندی داشت، این تابع را برای فرزندانش فراخوانی می‌کنیم
            if (!empty($itemData['children'])) {
                // برای پیدا کردن parent_id، باید id رکورد واسطی که الان ساخته شده را پیدا کنیم
                // با این کوئری آخرین رکورد اضافه شده به این منو را پیدا می‌کنیم که امن‌تر است
                $pivotId = $menu->categories()
                    ->where('category_id', $itemData['category_id'])
                    ->latest('category_menu.id') // <-- مرتب‌سازی بر اساس آخرین ID جدول واسط
                    ->first()->pivot->id;

                $this->saveMenuItems($menu, $itemData['children'], $pivotId);
            }
        }
    }
}
