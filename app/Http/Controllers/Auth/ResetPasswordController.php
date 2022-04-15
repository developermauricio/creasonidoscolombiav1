<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Aspirant;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    protected function redirectTo()
    {

        if (auth()->user()->roles[0]->name == "Administrador") {
            return route('reports.dashboard.page');
        } else if (auth()->user()->roles[0]->name == "Aspirante") {
            $aspirant = Aspirant::where('user_id', auth()->user()->id)->first();
            if ($aspirant->has_project === '1') {
                return route('aspirant.profile.page');
            } else {
                return route('aspirant.register.page');
            }
        } else if (auth()->user()->roles[0]->name == "Curador") {
            return route('curador.projects.page');
        } else if (auth()->user()->roles[0]->name == "Subsanador") {
            return route('subsanador.projects.page');
        } else {
            return '/dashboard';
        }
    }

    public function __construct()
    {
        $this->middleware('guest');
    }
}
