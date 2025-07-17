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
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Auth",
 *     description="Operaciones relacionadas con la autenticación"
 * )
 *
 */
class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * @OA\Post(
     *     path="/api/auth/login",
     *     summary="Login para obtener el token",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", format="email"),
     *             @OA\Property(property="password", type="string")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean"),
     *             @OA\Property(property="message", type="string"),
     *             @OA\Property(property="token", type="string")
     *         )
     *     ),
     *     security={}
     * )
     */
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

    /**
     * @OA\Post(
     *     path="/api/auth/logout",
     *     summary="Cerrar sesión",
     *     tags={"Auth"},
     *     security={{"Bearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Logout exitoso",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Logout successful")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor"
     *     )
     * )
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                throw new AuthenticationException('Unauthenticated', [], '', 401);
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

    /**
     * @OA\Post(
     *     path="/api/auth/revokeTokensByUser",
     *     summary="Revocar todos los tokens del usuario",
     *     tags={"Auth"},
     *     security={{"Bearer": {}}},
     *     @OA\Response(
     *         response=200,
     *         description="Tokens revocados exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Tokens revoked successfully"),
     *             @OA\Property(property="data", type="number", example=5)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error en el servidor"
     *     )
     * )
     */
    public function revokeTokensByUser(Request $request): int|JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                throw new AuthenticationException('Unauthenticated', [], '', 401);
            }

            $tokensDeleted = $this->authService->revokeTokensByUser($user);
            return response()->json([
                'success' => true,
                'message' => 'Tokens revoked successfully',
                'data' => $tokensDeleted
            ], 200);
        } catch (AuthenticationException|Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], $e->getCode() ?: 500);

        }
    }
}
