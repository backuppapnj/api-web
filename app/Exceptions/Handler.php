<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    /**
     * Report or log an exception.
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     * SECURITY: Always include security + CORS headers, even on error responses
     */
    public function render($request, Throwable $exception)
    {
        // Security headers untuk semua responses
        $securityHeaders = [
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block',
        ];

        // CORS headers untuk error responses
        // Diperlukan karena FatalError/exception bisa bypass middleware pipeline
        $origin = $request->header('Origin');
        $trustedDomains = [
            'https://pa-penajam.go.id',
            'https://www.pa-penajam.go.id',
        ];
        if (!empty($origin) && in_array($origin, $trustedDomains)) {
            $securityHeaders['Access-Control-Allow-Origin'] = $origin;
            $securityHeaders['Vary'] = 'Origin';
        }

        // Handle Validation Exception
        if ($exception instanceof ValidationException) {
            $response = response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $exception->errors()
            ], 422);

            foreach ($securityHeaders as $key => $value) {
                $response->header($key, $value);
            }
            return $response;
        }

        // Handle Model Not Found
        if ($exception instanceof ModelNotFoundException) {
            $response = response()->json([
                'success' => false,
                'message' => 'Resource not found'
            ], 404);

            foreach ($securityHeaders as $key => $value) {
                $response->header($key, $value);
            }
            return $response;
        }

        // Handle HTTP Exceptions
        if ($exception instanceof HttpException) {
            $response = response()->json([
                'success' => false,
                'message' => $exception->getMessage() ?: 'An error occurred'
            ], $exception->getStatusCode());

            foreach ($securityHeaders as $key => $value) {
                $response->header($key, $value);
            }
            return $response;
        }

        // SECURITY: Jangan expose stack trace atau pesan exception di production
        // Ref: https://lumen.laravel.com/docs/11.x/errors
        $isProduction = env('APP_ENV') === 'production' || env('APP_DEBUG') === false;

        // SECURITY: Log error untuk debugging internal
        \Illuminate\Support\Facades\Log::error('Unhandled exception', [
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        if ($isProduction) {
            // SECURITY: Sembunyikan detail exception dari response
            // Pesan asli hanya ada di log, bukan di response ke client
            $response = response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan pada server'
            ], 500);
        } else {
            // Development mode - tampilkan error details
            $response = response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
                'exception' => get_class($exception),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
            ], 500);
        }

        foreach ($securityHeaders as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
