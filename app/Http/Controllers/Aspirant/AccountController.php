<?php

namespace App\Http\Controllers\Aspirant;

use App\Http\Controllers\Controller;
use App\Mail\Aspirant\AccountCreate;
use App\Models\Aspirant;
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
}
