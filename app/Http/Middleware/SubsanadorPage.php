<?php

namespace App\Http\Middleware;

use App\Models\Aspirant;
use Closure;
use Illuminate\Support\Facades\Auth;

class SubsanadorPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,  $guard = null)
    {
        if (Auth::user()) {
            $userAdministrator = Auth::user()->hasRole('Administrador');
            $userSubsanador = Auth::user()->hasRole('Subsanador');

            if ($userAdministrator || $userSubsanador){
                return $next($request);
            }else{
                return back()->with('permission_denied', 'No tienes permiso para acceder');
            }
        }
    }
}
