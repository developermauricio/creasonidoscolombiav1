<?php

namespace App\Http\Controllers\Curador;

use App\Http\Controllers\Controller;
use App\Models\Aspirant;
use App\Models\Curador;
use App\Models\Proyect;
use App\Models\Qualification;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(){
        return view('curador.projects');
    }

    public function getProjects($id){
        $projects = Proyect::whereHas('curador', function ($q) use($id){
            $q->where('curador_id', $id);
        })->paginate(10);
        return response()->json($projects);
    }

    public function getQualifications(){
        $qualifications = Qualification::all();
        return response()->json(['data' => $qualifications]);
    }

    
}
