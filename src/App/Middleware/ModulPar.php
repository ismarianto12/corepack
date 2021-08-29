<?php

namespace Ismarianto\Ismarianto\App\Middleware;

use Closure;
use Ismarianto\Ismarianto\Lib\Tmparamtertr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Ismarianto\Ismarianto\Models\Tmmodul;

class ModulPar
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    function contains($needle, $haystack)
    {
        return strpos($haystack, $needle) !== false;
    }
    public function handle(Request $request, Closure $next)
    {
        $session = $request->session()->has('auths');
        $level = (Tmparamtertr::session('role')) ? Tmparamtertr::session('role')  : 0;
        $route = Route::current();
        $current_route = $route->getName();

        // dd($route);

        $caction = Route::currentRouteAction();
        if ($this->contains('@', $caction)) {
            $except = [
                'edit',
                'create',
                'delete',
                'store',
                'show',
                'update'
            ];
            $f = explode('@', $caction);
            if (in_array($f[1], $except)) {
                $cek_level = Tmmodul::select(
                    DB::raw('count([level]) as jmlev')
                )
                    ->first();
            } else {
                $cek_level =  Tmmodul::select(
                    DB::raw('count([level]) as jmlev')
                )
                    ->where(DB::Raw("CHARINDEX('" . $level . "', [level])"), '>', 0)
                    ->where('link', $current_route)
                    ->first();
            }
        } else {
            $cek_level = Tmmodul::select(
                DB::raw('count([level]) as jmlev')
            )
                ->where(DB::Raw("CHARINDEX('" . $level . "', [level])"), '>', 0)
                ->where('link', $current_route)
                ->first();
        }
        if ($session == TRUE) {
            if ($cek_level->jmlev > 0) {
                return $next($request);
            }
            return abort('403');
        }
        return redirect()->route('/');
    }
}
