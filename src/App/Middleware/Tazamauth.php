<?php

namespace Ismarianto\Ismarianto\App\Middleware;

use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Ismarianto\Ismarianto\Models\Tmmodul;

class Tazamauth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$cr)
    {
        $session = $request->session()->has('auths');
        $level = (Tmparamtertr::session('role')) ? Tmparamtertr::session('role')  : 0;
        $route = Route::current();
        $current_route = $route->getName();

        if ($session == TRUE) {
            return $next($request);
        }
        return redirect()->route('login');
    }
}
