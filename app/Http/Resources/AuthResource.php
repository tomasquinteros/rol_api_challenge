<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
