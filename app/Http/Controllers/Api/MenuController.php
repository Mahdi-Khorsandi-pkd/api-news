<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuItemResource;
use App\Http\Resources\MenuResource;
use App\Models\Menu;
use App\Services\MenuService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class MenuController extends Controller
{
    use ApiResponse;

    protected MenuService $menuService;

    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }

    /**
     * Get list of all menus (for admin panel).
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', Menu::class);
        $menus = $this->menuService->getAllMenus();
        return $this->successResponse(MenuResource::collection($menus));
    }

    /**
     * Get a specific menu's hierarchical structure (for public view).
     */
    public function show(Menu $menu): JsonResponse
    {
        $this->authorize('view', $menu);
        $menuTree = $this->menuService->getMenuByLocation($menu->location);

        $data = [
            'name' => $menu->name,
            'location' => $menu->location,
            'items' => MenuItemResource::collection($menuTree),
        ];

        return $this->successResponse($data);
    }

    // متد sync را در مرحله بعد تکمیل می‌کنیم
    // public function sync(...) {}
}
