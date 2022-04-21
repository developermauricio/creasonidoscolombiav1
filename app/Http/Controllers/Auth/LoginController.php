<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Aspirant;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {
        $userAdministrator = \auth()->user()->hasRole('Administrador');
        $userAspirant = \auth()->user()->hasRole('Aspirante');
        $userCurador = \auth()->user()->hasRole('Curador');
        $userSubsanador = \auth()->user()->hasRole('Subsanador');

        /*=============================================
            VALIDAMOS EL ROL
        =============================================*/
        if ($userAdministrator) {
            return route('reports.dashboard.page');
        } else if ($userAspirant) {
            /*=============================================
                VALIDAMOS EL ESTADO DEL ASPIRANTE
            =============================================*/
            $aspirant = Aspirant::where('user_id', \auth()->user()->id)->first();
            if ($aspirant->has_project === '1') {
                return route('aspirant.profile.page');
            } else {
                return route('aspirant.register.page');
            }
        }else if($userCurador){
            return route('curador.projects.page');
        }else if ($userSubsanador){
            return route('subsanador.projects.page');
        }
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();

        return redirect('/login');
    }
}
