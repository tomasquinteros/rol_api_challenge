<?php

namespace App\Http\Controllers\Api;

use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *     title="API de ROL Challenge",
 *     description="Documentación de la API para el reto de ROL",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="contacto@rolchallenge.com"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="Bearer",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     description="JWT Authentication"
 * )
 */
class Swagger
{
}
