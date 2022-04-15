<?php

namespace App\Http\Controllers\Subsanador;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(){
        return view('subsanador.projects');
    }
}
