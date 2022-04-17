<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        return view('user.user');
    }

    public function getUsers(){
        $user = User::role(['Administrador', 'Curador', 'Subsanador'])->with('roles')->get();
        return response()->json(['data' => $user]);
    }
}
