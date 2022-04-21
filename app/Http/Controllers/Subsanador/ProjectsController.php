<?php

namespace App\Http\Controllers\Subsanador;

use App\Http\Controllers\Controller;
use App\Models\Proyect;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(){
        return view('subsanador.projects');
    }

    public function getProjectsRevision(){
        $projects = Proyect::where('state', Proyect::REVISION)->with(
            'aspirant.user.city.departament', 'aspirant.aspirant_type',
            'aspirant.categoryAspirant', 'aspirant.user.gender', 'aspirant.ethnic', 'aspirant.parent.minor'
        )->get();
        return response()->json(['data' => $projects]);
    }
}
