<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="AuthResource",
 *     type="object",
 *     @OA\Property(property="success", type="boolean", example=true),
 *     @OA\Property(property="message", type="string", example="Login successful"),
 *     @OA\Property(
 *         property="data",
 *         type="object",
 *         @OA\Property(property="user", type="object",
 *             @OA\Property(property="id", type="integer", example=1),
 *             @OA\Property(property="name", type="string", example="John Doe"),
 *             @OA\Property(property="email", type="string", example="john@example.com"),
 *             @OA\Property(property="created_at", type="string", format="date-time", example="2022-01-01T00:00:00Z")
 *         ),
 *         @OA\Property(property="token", type="string", example="your_jwt_token"),
 *         @OA\Property(property="token_type", type="string", example="Bearer"),
 *         @OA\Property(property="expires_at", type="string", format="date-time", example="2022-12-31T23:59:59Z")
 *     )
 * )
 */
class AuthResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $this->resource['user']->id,
                    'name' => $this->resource['user']->name,
                    'email' => $this->resource['user']->email,
                    'created_at' => $this->resource['user']->created_at,
                ],
                'token' => $this->resource['token'],
                'token_type' => 'Bearer',
                'expires_at' => null,
            ]
        ];
    }
}
