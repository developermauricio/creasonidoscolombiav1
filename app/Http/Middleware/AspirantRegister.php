<?php

namespace App\Http\Middleware;

use App\Models\Aspirant;
use Closure;
use Illuminate\Support\Facades\Auth;

class AspirantRegister
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_id = Auth::user()->id;
        $aspirant = Aspirant::where('user_id', $user_id)->first();
        if ($aspirant->has_project === '2'){
            return $next($request);
        }else{
            return back()->with('permission_denied', 'No tienes permiso para acceder');
        }

    }
}
