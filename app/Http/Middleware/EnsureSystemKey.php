<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSystemKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (
            !$request->header('System-Key') ||
            $request->header('System-Key') !== config('app.system_key')
        ) {
            return response()->json([
                'result' => false,
                'message' => 'Request not found!'
            ]);
        }

        return $next($request);
    }
}
