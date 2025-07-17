<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if (class_basename($e) == 'ValidationException') {
            return response()->json(["errors" => $e->errors(), "message" => $e->getMessage()], 422);
        }
        if (class_basename($e) == 'AuthenticationException') {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 401);
        }
        return response()->json([
            'error' => [
                'exception' => class_basename($e) . ' in ' . basename($e->getFile()) . ' line ' . $e->getLine() . ': ' . $e->getMessage(),
            ]
        ], 500);
    }
}
