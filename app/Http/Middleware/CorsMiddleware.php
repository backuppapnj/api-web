<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Handle CORS headers dengan security yang ketat
     * SECURITY: Whitelist origins, tidak menggunakan wildcard di production
     */
    public function handle(Request $request, Closure $next)
    {
        $allowedOriginsRaw = env('CORS_ALLOWED_ORIGINS', '');
        $allowedOrigins = array_filter(array_map('trim', explode(',', $allowedOriginsRaw)));
        $origin = $request->header('Origin');

        $headers = [
            'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
            'Access-Control-Allow-Headers' => 'Content-Type, X-API-Key, Accept',
            'Access-Control-Max-Age' => '86400',
            'X-Content-Type-Options' => 'nosniff',
            'X-Frame-Options' => 'DENY',
            'X-XSS-Protection' => '1; mode=block',
        ];

        // SECURITY: Hanya allow origin yang ada di whitelist
        if (!empty($origin) && in_array($origin, $allowedOrigins)) {
            $headers['Access-Control-Allow-Origin'] = $origin;
            $headers['Vary'] = 'Origin';
        } elseif (empty($allowedOrigins) || in_array('*', $allowedOrigins)) {
            // WARNING: Hanya gunakan ini untuk development
            $headers['Access-Control-Allow-Origin'] = '*';
        }
        // Jika origin tidak diizinkan, tidak ada header CORS = browser akan blokir

        // Handle preflight request
        if ($request->isMethod('OPTIONS')) {
            return response('', 200, $headers);
        }

        $response = $next($request);

        foreach ($headers as $key => $value) {
            $response->header($key, $value);
        }

        return $response;
    }
}
