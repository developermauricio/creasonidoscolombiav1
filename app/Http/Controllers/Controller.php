<?php

namespace App\Http\Controllers;

use App\CategoryAspirant;
use App\Models\Aspirant;
use App\Models\Category;
use App\Models\City;
use App\Models\Departament;
use App\Models\DocumentType;
use App\Models\Ethnic;
use App\Models\Gender;
use App\Models\Proyect;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Spatie\Permission\Models\Role;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    private $roles = null;

    public function __construct()
    {
        $this->roles = Role::whereIn('name', ['Administrador', 'Curador', 'Subsanador'])->get();
    }


    public function getDepartaments()
    {
        $departaments = Departament::all();
        return response()->json(['data' => $departaments]);
    }

    public function getCities($id)
    {
        $cities = City::where('iddepartamento', $id)->get();
        return response()->json(['data' => $cities]);
    }

    public function getGenders()
    {
        $genders = Gender::all();
        return response()->json(['data' => $genders]);
    }

    public function getProjectCategories()
    {
        $categories = Category::all();
        return response()->json(['data' => $categories]);
    }

    public function categoryAspirant()
    {
        $categories = CategoryAspirant::all();
        return response()->json(['data' => $categories]);
    }

    public function getEthnics()
    {
        $ethnics = Ethnic::all();
        return response()->json(['data' => $ethnics]);
    }

    public function validateEmail($email)
    {
        $check = User::whereEmail($email)->first();
        if ($check !== null) {
            return response()->json('El correo electrónico ya ha sido registrado, por favor ingrese otro', 200);
        } else {
            return response()->json(300, 200);
        }
    }

    public function getDocumentTypes()
    {
        $documentsTypes = DocumentType::all();
        return response()->json(['data' => $documentsTypes]);
    }

    public function getRoles()
    {
        $roles = $this->roles;
        return response()->json(['data' => $roles]);
    }

    public function getDataReports()
    {
        $projects = Proyect::all()->count();
        $aspirantes = Aspirant::all()->count();
        $date = Carbon::parse(Carbon::now())->format('M, d Y H:i:s A');
        /*=============================================
            GENERO
        =============================================*/
        $aspirantesHombres = Aspirant::whereHas('user', function ($q){
           return $q->where('gender_id', 1);
        })->count();
        $aspirantesMujeres = Aspirant::whereHas('user', function ($q){
            return $q->where('gender_id', 2);
        })->count();
        $aspirantesOtros = Aspirant::whereHas('user', function ($q){
            return $q->where('gender_id', 3);
        })->count();
        $aspirantesNoReporta = Aspirant::whereHas('user', function ($q){
            return $q->where('gender_id', 4);
        })->count();

        /*=============================================
        SU COMENTARIO
        =============================================*/

        $data = [
            [   'Fecha actual' => $date,
                'Total aspirantes con propuesta musical' => $projects,
                'Total de hombres' => $aspirantesHombres,
                'Total de mujeres' => $aspirantesMujeres,
                'Total de género otros' => $aspirantesOtros,
                'Total no reporta género' => $aspirantesNoReporta,
                'Total aspirantes registrados solo con cuenta' => $aspirantes,

            ],
        ];
        return $data;
    }
}
