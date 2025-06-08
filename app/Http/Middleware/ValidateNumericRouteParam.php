<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ValidateNumericRouteParam
{
    /**
     * Handle an incoming request.
     * This middleware validates that a specific route parameter is numeric and positive.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $param  The name of the route parameter to validate
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $param): Response
    {
        // Get the route parameter value
        $value = $request->route($param);

        // Check if the parameter is numeric
        if (!is_numeric($value)) {
            return response()->json([
                'error' => 'Invalid parameter. Must be a numeric value.'
            ], 422);
        }

        // Check if the numeric value is a positive number
        if ($value < 0) {
            return response()->json([
                'error' => 'Invalid parameter. Must be a positive numeric value.'
            ], 422);
        }

        // If the parameter is valid, proceed with the request
        return $next($request);
    }
}
