<?php

namespace App\Http\Controllers\Aspirant;

use App\Http\Controllers\Controller;
use App\Mail\Aspirant\AccountCreate;
use App\Models\Aspirant;
use App\Models\Curador;
use App\Models\Proyect;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function createAccount(Request $request)
    {
        $name = $request->get('name');
        $lastName = $request->get('last_name');
        $email = $request->get('email');

        $password = Str::random(8);
        $pass = bcrypt($password);

       $user = User::create([
            'name' => $name,
            'last_name' => $lastName,
            'email' => $email,
            'password' => $pass
        ]);
       Aspirant::create([
          'user_id' => $user->id
       ]);
       $user->roles()->attach('2');
       Mail::to($email)->send(new AccountCreate($name, $lastName, $password, $email));

       return redirect('/login')->with('success-account', 'Cuanta creada exitosamente. Hemos enviado una contraseña de acceso a tu correo electrónico.');


    }

    /* Consultas para los reportes */
    public function getAllAspirantsRegisters() {
        $listAspirant = Aspirant::with('user')
            ->get();
        return response()->json(['status' => 'ok', 'data' => $listAspirant]);
    }

    public function getAllAspirants() {
        $listAspirant = Aspirant::with('user', 'aspirantType')
            ->where('aspirant_type_id', '<>', null)
            //->where('id', '>', 10)
            ->get();
        return response()->json(['status' => 'ok', 'data' => $listAspirant]);
    }

    public function getAllAspirantsLocation() {
        $listAspirant = Aspirant::with('user', 'user.city', 'user.city.departament')
            ->where('aspirant_type_id', '<>', null)
            ->get();

        return response()->json(['status' => 'ok', 'data' => $listAspirant]);
    }

    public function getAllCuradors() {
        $listCuradors = Curador::with('user', 'category')
            ->get();
        return response()->json(['status' => 'ok', 'data' => $listCuradors]);
    }

    public function getAllProjects() {
        $listProjects = Proyect::with('category')->get();
        return response()->json(['status' => 'ok', 'data' => $listProjects]);
    }

    public function getAllCuradorProject() {
        $listProjects = Proyect::with('category')->get();
        return response()->json(['status' => 'ok', 'data' => $listProjects]);
    }
}
