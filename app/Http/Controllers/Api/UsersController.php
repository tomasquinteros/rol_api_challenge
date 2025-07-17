<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="Operaciones relacionadas con los usuarios"
 * )
 *
 */
class UsersController extends Controller
{
    public function __construct(protected UserInterface $user)
    {
    }

    /**
 * @OA\Get(
 *     path="/api/users",
 *     summary="Obtener lista de usuarios",
 *     tags={"Users"},
 *     @OA\Parameter(
 *         name="limit",
 *         in="query",
 *         required=false,
 *         description="Número de usuarios a devolver",
 *         @OA\Schema(type="integer", example=15)
 *     ),
*     @OA\Parameter(
 *         name="name",
 *         in="query",
 *         required=false,
 *         description="Nombre de usuario a buscar",
 *         @OA\Schema(type="string", example="admin")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Lista de usuarios",
 *         @OA\JsonContent(
 *             type="array",
 *             @OA\Items(ref="#/components/schemas/UserResource")
 *         )
 *     ),
 *     @OA\Response(
 *         response=401,
 *         description="No autenticado"
 *     ),
 *     @OA\Response(
 *         response=500,
 *         description="Error en el servidor"
 *     ),
 *     security={{"Bearer":{}}}
 * )
 */
    public function index(UserRequest $request): AnonymousResourceCollection|JsonResponse
    {
        try {
            $limit = $request->input('limit', 15);
            $limit = min($limit, 100);

            if (!empty($request->has('name'))) {
                return UserResource::collection($this->user->getByName($request['name'], $limit));
            }
            return UserResource::collection($this->user->getAll($limit));
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()],
                $e->getCode() ?: 500
            );
        }
    }
}
