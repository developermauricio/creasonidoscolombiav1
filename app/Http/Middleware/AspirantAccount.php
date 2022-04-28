<?php

namespace App\Http\Middleware;

use App\Models\Aspirant;
use Closure;
use Illuminate\Support\Facades\Auth;

class AspirantAccount
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
        if (Auth::user()) {
            $userAdministrator = Auth::user()->hasRole('Administrador');
            $userAspirant = Auth::user()->hasRole('Aspirante');
            $userCurador = Auth::user()->hasRole('Curador');
            $userSubsanador = Auth::user()->hasRole('Subsanador');

            if (Auth::guard($guard)->check()) {
                if ($userAdministrator) {
                    return '/dashboard';
                } else if ($userAspirant) {
                    $aspirant = Aspirant::where('user_id', Auth::user()->id)->first();
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
