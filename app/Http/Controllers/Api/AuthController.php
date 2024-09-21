<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RefreshTokenRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    private AuthService $mainService;

    /**
     * @param AuthService $mainService
     */
    public function __construct(
        AuthService $mainService
    )
    {
        $this->mainService = $mainService;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->mainService->login(payload: $request->toArray());
        if ($result['status'] === false) return self::failResponse(data: $result['data'], code: 401, message: $result['message']);
        return self::successResponse(data: $result['data'], message: $result['message']);
    }

    /**
     * @param RefreshTokenRequest $request
     * @return JsonResponse
     */
    public function refreshToken(RefreshTokenRequest $request): JsonResponse
    {
        $result = $this->mainService->refreshToken(payload: $request->toArray());
        if ($result['status'] === false) return self::failResponse(data: $result['data'], code: 401, message: $result['message']);
        return self::successResponse(data: $result['data'], message: $result['message']);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $user = Auth::user();
        $result = $this->mainService->logout(user: $user);
        if (!$result['status']) return self::failResponse(code: 500, message: 'Failed to logout');
        return self::successResponse(message: $result['message']);
    }
}
