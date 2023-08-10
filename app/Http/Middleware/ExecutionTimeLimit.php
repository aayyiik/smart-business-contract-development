<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ExecutionTimeLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        ini_set('max_execution_time', 300); // Waktu dalam detik
        return $next($request);
    }
}
