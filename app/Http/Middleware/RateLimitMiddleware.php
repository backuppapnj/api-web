<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class RateLimitMiddleware
{
    /**
     * Simple rate limiting middleware
     * SECURITY: Mencegah API abuse dan DDoS
     */
    public function handle(Request $request, Closure $next, int $maxAttempts = 60, int $decayMinutes = 1)
    {
        $key = 'rate_limit:' . $this->resolveRequestSignature($request);

        // Gunakan file cache jika tidak ada Redis
        $attempts = Cache::get($key, 0);

        if ($attempts >= $maxAttempts) {
            return response()->json([
                'success' => false,
                'message' => 'Too many requests. Please try again later.',
                'retry_after' => $decayMinutes * 60
            ], 429)->header('Retry-After', $decayMinutes * 60);
        }

        // Increment counter
        Cache::put($key, $attempts + 1, \Carbon\Carbon::now()->addMinutes($decayMinutes));

        $response = $next($request);

        // Add rate limit headers
        return $response
            ->header('X-RateLimit-Limit', $maxAttempts)
            ->header('X-RateLimit-Remaining', max(0, $maxAttempts - $attempts - 1));
    }

    protected function resolveRequestSignature(Request $request): string
    {
        // SECURITY: Hanya gunakan IP sebagai identifier
        // User-Agent bisa dimanipulasi untuk bypass rate limit
        // Ref: https://benjamincrozat.com/laravel-security-best-practices
        return sha1($request->ip());
    }
}
