<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    /**
     * نمایش لیست دسته‌بندی‌ها
     */
    public function index(): JsonResponse
    {
        // استفاده از paginate برای مدیریت بهتر داده‌های زیاد
        $categories = Category::latest()->paginate(15);
        return response()->json($categories);
    }

    /**
     * ذخیره یک دسته‌بندی جدید
     */
    public function store(StoreCategoryRequest $request): JsonResponse
    {
        $category = Category::create($request->validated());
        return response()->json($category, Response::HTTP_CREATED);
    }

    /**
     * نمایش یک دسته‌بندی خاص
     */
    public function show(Category $category): JsonResponse
    {
        // با استفاده از Route Model Binding، لاراول خودش دسته بندی رو پیدا می‌کنه
        return response()->json($category);
    }

    /**
     * ویرایش یک دسته‌بندی
     */
    public function update(UpdateCategoryRequest $request, Category $category): JsonResponse
    {
        $category->update($request->validated());
        return response()->json($category);
    }

    /**
     * حذف یک دسته‌بندی
     */
    public function destroy(Category $category): Response
    {
        $category->delete();
        // کد 204 یعنی عملیات موفق بود و هیچ محتوایی برای بازگشت وجود ندارد
        return response()->noContent();
    }
}
