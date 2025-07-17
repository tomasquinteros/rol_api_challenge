<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\LoginRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    public function login(LoginRequest $request): AuthResource|JsonResponse
    {
        try {
            $authData = $this->authService->authenticate($request->validated());
            return new AuthResource($authData);

        } catch (AuthenticationException|Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                throw new AuthenticationException('Unauthenticated', [],'', 401);
            }

            $logoutSuccess = $this->authService->logout($user);

            if (!$logoutSuccess) {
                throw new Exception('Logout failed', 500);
            }

            return response()->json([
                'success' => true,
                'message' => 'Logout successful'
            ], 200);

        } catch (AuthenticationException|Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);
        }
    }

    public function revokeTokensByUser(Request $request): int|JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                throw new AuthenticationException('Unauthenticated', [], '', 401);
            }

            return $this->authService->revokeTokensByUser($user);

        } catch (AuthenticationException|Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);

        }
    }
}
