<?php

namespace App\Http\Middleware;

use App\Traits\ResponseTrait;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    use ResponseTrait;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return $next($request);
        // $apiKey = $request->header('x-api-key');

        // if ($apiKey !== config('auth.api_key')) {
        //     return $this->unauthorizedResponse('Invalid api key set');
        // }
        // return $next($request);
    }
}
