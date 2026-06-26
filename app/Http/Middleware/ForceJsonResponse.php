<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');

        // Jika request memiliki body berupa JSON tapi Content-Type tidak di-set (sering terjadi di script tester M2M),
        // kita paksa Laravel untuk membacanya sebagai JSON.
        if (in_array($request->method(), ['POST', 'PUT', 'PATCH']) && empty($request->all())) {
            $content = $request->getContent();
            if (!empty($content)) {
                $decoded = json_decode($content, true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    $request->merge($decoded);
                }
            }
        }

        $response = $next($request);

        // Optional: you can also force the Content-Type of the response to be application/json
        if (method_exists($response, 'header')) {
            $response->header('Content-Type', 'application/json');
        }

        return $response;
    }
}
