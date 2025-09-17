<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use App\Services\AuthService;
use App\Traits\ApiResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    protected AuthService $authService;

    /**
     * Create a new AuthController instance.
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'username'   => $data['username'],
            'email'      => $data['email'],
            'password'   => Hash::make($data['password']),
        ]);

        $user->assignRole($data['role']);

        return $this->successResponse(
            ['user' => $user],
            'کاربر جدید با موفقیت ایجاد شد.',
            Response::HTTP_CREATED
        );
    }

    /**
     * Get a token via given credentials.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request->validated());

            return $this->successResponse($result, 'ورود با موفقیت انجام شد.');

        } catch (AuthenticationException $e) {

            return $this->errorResponse($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     */
    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->successResponse(null, 'خروج از حساب کاربری موفقیت آمیز بود.');
    }
}
