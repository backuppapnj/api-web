<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    /**
     * Validasi API Key untuk protected routes
     * SECURITY: Menggunakan hash_equals() untuk timing-safe comparison
     */
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-Key');
        $validKey = env('API_KEY');

        // SECURITY: Cek apakah API_KEY sudah dikonfigurasi
        if (empty($validKey)) {
            return response()->json([
                'success' => false,
                'message' => 'Server configuration error'
            ], 500);
        }

        // SECURITY: Timing-safe comparison untuk mencegah timing attacks
        if (empty($apiKey) || !hash_equals($validKey, $apiKey)) {
            // SECURITY: Delay untuk mencegah brute force
            usleep(random_int(100000, 300000)); // 100-300ms delay

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        return $next($request);
    }
}
