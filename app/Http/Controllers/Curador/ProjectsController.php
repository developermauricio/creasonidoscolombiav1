<?php

namespace App\Http\Controllers\Curador;

use App\Http\Controllers\Controller;
use App\Models\Aspirant;
use App\Models\Curador;
use App\Models\Proyect;
use App\Models\Qualification;
use App\Models\QualificationProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProjectsController extends Controller
{
    public function index()
    {
        return view('curador.projects');
    }

    public function getProjects(){
        $curadores = Curador::with('user', 'categories')->withCount('projects')
            ->get();

        return $curadores;
    }

    public function getProjectsForId($id)
    {
        // '@rownum:= @rownum + 1 AS row'
        $projects = Proyect::whereHas('curador', function ($q) use ($id) {
            $q->where('curador_id', $id);
        })
            ->orderBy('state')
            ->paginate(10);
        return response()->json($projects);
    }

    public function getQualifications()
    {
        $qualifications = Qualification::all();
        return response()->json(['data' => $qualifications]);
    }

    public function getProjectsQualified($id)
    {
        $projects = Proyect::whereHas('curador', function ($q) use ($id) {
            $q->where('curador_id', $id);
        })
            ->where('state', Proyect::QUALIFIED)
            ->get()
            ->count();
        return response()->json($projects);
    }
    public function getProjectsAsign($id)
    {
        $projects = Proyect::whereHas('curador', function ($q) use ($id) {
            $q->where('curador_id', $id);
        })
            ->where('state', Proyect::ACEPTED)
            ->get()
            ->count();
        return response()->json($projects);
    }

    public function saveQualification(Request $request)
    {
        $data = $request->all();
        $newQualification = new QualificationProject($data);
        $newQualification->interpretive_quality = $data['interpretive_quality'];
        $newQualification->quality_proposal = $data['quality_proposal'];
        $newQualification->composition_quality = $data['composition_quality'];
        $newQualification->song_potential = $data['song_potential'];
        $newQualification->territorial_value = $data['territorial_value'];
        $newQualification->proyect_id = $data['proyect_id'];
        $newQualification->curadores_id = $data['curadores_id'];
        $newQualification->save();
        $proyect = Proyect::find($data['proyect_id']);
        $proyect->update([
            'state' => 4,
        ]);

        return response()->json($data, 201);
    }
    public function getProjectsReview($id)
    {
        $projects = Proyect::whereHas('curador', function ($q) use ($id) {
            $q->where('curador_id', $id);
        })
            ->where('state', Proyect::QUALIFIED)
            ->get()
            ->count();
        return response()->json($projects);
    }
}
