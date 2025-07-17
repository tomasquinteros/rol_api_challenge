<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function index(UserRequest $request): JsonResponse
    {
        $limit = min($request->input('limit', 15), 100);

        if (!empty($request->has('name'))) {
            $users = $this->user->getByName($request['name']);
        } else {
            $users = $this->user->getAll();
        }

        if ($users->count() === 0) {
            throw new ModelNotFoundException('No users found', 404);
        }

        $users = $users->paginate($limit);

        return response()->json([
            'data' => UserResource::collection($users->items()),
            'meta' => [
                'current_page' => $users->currentPage(),
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'last_page' => $users->lastPage(),
                'has_next' => $users->hasMorePages(),
                'has_prev' => $users->currentPage() > 1,
            ]
        ]);
    }
}
