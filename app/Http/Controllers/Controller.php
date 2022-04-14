<?php

namespace App\Http\Controllers;

use App\CategoryAspirant;
use App\Models\Category;
use App\Models\City;
use App\Models\Departament;
use App\Models\Ethnic;
use App\Models\Gender;
use App\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getDepartaments(){
        $departaments = Departament::all();
        return response()->json(['data' => $departaments]);
    }

    public function getCities($id){
        $cities = City::where('iddepartamento', $id)->get();
        return response()->json(['data' => $cities]);
    }

    public function getGenders(){
        $genders = Gender::all();
        return response()->json(['data' => $genders]);
    }

    public function getProjectCategories(){
        $categories = Category::all();
        return response()->json(['data' => $categories]);
    }

    public function categoryAspirant(){
        $categories = CategoryAspirant::all();
        return response()->json(['data' => $categories]);
    }

    public function getEthnics(){
        $ethnics = Ethnic::all();
        return response()->json(['data' => $ethnics]);
    }

    public function validateEmail($email)
    {
        $check = User::whereEmail($email)->first();
        if ($check !== null) {
            return response()->json('El correo electrónico ya ha sido registrado, por favor ingrese otro', 200);
        }else{
            return response()->json(300, 200);
        }
    }
}
