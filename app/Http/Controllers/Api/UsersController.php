<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UsersController extends Controller
{
    public function __construct(protected UserInterface $user)
    {
    }

    public function index(UserRequest $request): AnonymousResourceCollection|JsonResponse
    {
        try {
            if (!empty($request->has('name'))) {
                return UserResource::collection($this->user->getByName($request['name']));
            }
            return UserResource::collection($this->user->getAll());
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()],
                $e->getCode() ?: 500
            );
        }
    }
}
