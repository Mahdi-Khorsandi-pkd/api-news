<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SyncCategoriesRequest;
use App\Http\Resources\SectionResource; // <-- ۱. ریسورس را اضافه کن
use App\Models\Section;
use App\Services\SectionService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class SectionController extends Controller
{
    use ApiResponse;

    protected SectionService $sectionService;

    public function __construct(SectionService $sectionService)
    {
        $this->sectionService = $sectionService;

        // به جز متدهای index و show، بقیه را محافظت کن
        $this->authorizeResource(Section::class, 'section', [
            'except' => ['index'],
        ]);
    }
    public function index(): JsonResponse
    {
        // $this->authorize('viewAny', Section::class); // authorizeResource این کار را انجام می‌دهد
        $sections = $this->sectionService->getAllSections();

        // ۲. استفاده از ریسورس برای کالکشن
        return $this->successResponse(SectionResource::collection($sections), 'بخش‌ها با موفقیت دریافت شدند.');
    }

    public function show(Section $section): JsonResponse
    {
        // $this->authorize('view', $section); // authorizeResource این کار را انجام می‌دهد
        $sectionWithCategories = $this->sectionService->getSectionWithCategories($section);

        // ۳. استفاده از ریسورس برای یک آیتم
        return $this->successResponse(new SectionResource($sectionWithCategories));
    }

    public function syncCategories(SyncCategoriesRequest $request, Section $section): JsonResponse
    {
        $this->authorize('syncCategories', $section); // این متد در authorizeResource نیست، پس جداگانه می‌ماند

        $this->sectionService->syncCategories($section, $request->validated()['category_ids']);

        return $this->successResponse(null, 'دسته بندی ها با موفقیت همگام سازی شدند.');
    }
}
