<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
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
        return $this->successResponse($categories, 'Categories fetched successfully.');
    }

    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = $this->categoryService->createCategory($request->validated());
        return $this->successResponse($category, 'Category created successfully.', Response::HTTP_CREATED);
    }

    public function show(Category $category): JsonResponse
    {
        return $this->successResponse($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $this->categoryService->updateCategory($category, $request->validated());
        return $this->successResponse($category, 'Category updated successfully.');
    }

    public function destroy(Category $category): JsonResponse
    {
        $this->categoryService->deleteCategory($category);
        return $this->successResponse(null, 'Category deleted successfully.');
    }
}
