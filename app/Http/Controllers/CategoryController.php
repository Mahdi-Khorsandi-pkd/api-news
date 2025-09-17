<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    use ApiResponse;

    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;

        // Apply policy for all resourceful methods except index and show
        $this->authorizeResource(Category::class, 'category', [
            'except' => ['index', 'show'],
        ]);
    }

    public function index(): JsonResponse
    {
        $categories = $this->categoryService->getAllCategories();
        // برای لیست‌ها از متد collection استفاده می‌کنیم
        return $this->successResponse(CategoryResource::collection($categories), 'دسته بندی با موفقیت دریافت شد .');
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->createCategory($request->validated());
        return $this->successResponse(new CategoryResource($category), 'دسته بندی با موفقیت ساخته شد.', Response::HTTP_CREATED);
    }

    public function show(Category $category): JsonResponse
    {
        // لود کردن روابط برای نمایش در ریسورس
        $category->load(['parent', 'children']);
        return $this->successResponse(new CategoryResource($category));
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $this->categoryService->updateCategory($category, $request->validated());
        return $this->successResponse(new CategoryResource($category), 'دسته بندی با موفقیت ویرایش شد.');
    }


    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->deleteCategory($category);
        return $this->successResponse(null, 'دسته بندی با موفقیت حذف شد.');
    }
}
