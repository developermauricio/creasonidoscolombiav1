<?php

namespace App\Http\Middleware;

use App\Models\Aspirant;
use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
//        if (Auth::guard($guard)->check()) {
//            return redirect('/');
//        }
//
//        return $next($request);
        if (Auth::user()) {
            $userAdministrator = Auth::user()->hasRole('Administrador');
            $userAspirant = Auth::user()->hasRole('Aspirante');
            $userCurador = Auth::user()->hasRole('Curador');
            $userSubsanador = Auth::user()->hasRole('Subsadanor');
            $aspirant = Aspirant::where('user_id', Auth::user()->id)->first();

            if (Auth::guard($guard)->check()) {
                if ($userAdministrator) {
                    return '/dashboard';
                } else if ($userAspirant && $aspirant->accept_termi) {

                    if ($aspirant->has_project === '1') {
                        return redirect('/perfil');
                    } else {
                        return redirect('/registro');
                    }
                } else if ($userCurador) {
                    return redirect('/curador');
                } else if ($userSubsanador) {
                    return redirect('/subsanador');
                }
                return back();
//            return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
