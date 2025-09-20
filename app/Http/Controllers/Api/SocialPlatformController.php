<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocialPlatformResource;
use App\Models\SocialPlatform;
use App\Services\SocialPlatformService;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;

class SocialPlatformController extends Controller
{
    use ApiResponse;

    protected SocialPlatformService $socialPlatformService;

    public function __construct(SocialPlatformService $socialPlatformService)
    {
        $this->socialPlatformService = $socialPlatformService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $this->authorize('viewAny', SocialPlatform::class);

        $platforms = $this->socialPlatformService->getAllPlatforms();

        return $this->successResponse(
            SocialPlatformResource::collection($platforms),
            'Social platforms fetched successfully.'
        );
    }
}
