<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


/**
 * This middleware check if the request has api_token key and adds this into the Authorization header to take advantage of
 * the sanctum middleware
 */
class AddTokenToHeader
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $all = $request->all();
        if (isset($all['api_token'])) {
            $request->headers->set('Authorization', sprintf('%s %s', 'Bearer', $all['api_token']));
        }
        return $next($request);
    }
}