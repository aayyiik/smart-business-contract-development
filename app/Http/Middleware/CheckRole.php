<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Role;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, $role)
    {
     

        if (! $request->user()->hasRole($role)) {
            abort(401, 'This action is unauthorized.');
        }

        // if(Auth::check() && Auth::user()->status != 1){
        //     Auth::logout();
        //     return redirect('/login');
        // }
        return $next($request);
    }
}
