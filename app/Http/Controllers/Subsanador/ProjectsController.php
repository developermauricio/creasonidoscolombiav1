<?php

namespace App\Http\Controllers\Subsanador;

use App\Http\Controllers\Controller;
use App\Models\Proyect;
use App\Models\Subsanador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProjectsController extends Controller
{
    public function index()
    {
        return view('subsanador.projects');
    }

    public function getProjects()
    {
        $projects = Proyect::with(
            'aspirant.user.city.departament', 'aspirant.aspirant_type',
            'aspirant.categoryAspirant', 'aspirant.user.gender', 'aspirant.ethnic', 'aspirant.parent.minor'
        )->latest()->get();
        return response()->json(['data' => $projects]);
    }

    public function getProjectsRevision()
    {
        $projects = Proyect::where('state', Proyect::REVISION)->with(
            'aspirant.user.city.departament', 'aspirant.aspirant_type',
            'aspirant.categoryAspirant', 'aspirant.user.gender', 'aspirant.ethnic', 'aspirant.parent.minor'
        )->get();
        return response()->json(['data' => $projects]);
    }

    public function assignProject(Request $request)
    {
        $category = json_decode($request->category);
        $projectId = $request->projectId;
        $currentUserId = $request->currentUserId;

        /*=============================================
           BUSCAMOS CURADORES ASIGNADOS A UNA CATEGORÍA
       =============================================*/
        $curadorCategory = DB::table('curador_categories')
            ->where('category_id', $category->id)
            ->get();

//        if (count($curadorCategory) === 0) return response()->json('No hay un curador asignado a la modalidad ' . $category->category, 401);
        if (count($curadorCategory) > 0) {
            $randomCurador = $curadorCategory[mt_rand(0, count($curadorCategory) - 1)];
            /*=============================================
                ASIGNAMOS LA PROPUESTA MUSICAL AL CURADOR
            =============================================*/
            if($randomCurador->curador_id !== 7){
                $curadorProject = DB::table('curador_projects')
                    ->insert([
                        'curador_id' => $randomCurador->curador_id,
                        'proyect_id' => $projectId
                    ]);
            }

        }
        /*=============================================
            ACTUALIZAMOS LA CATEGORÍA DEL PROYECTO
        =============================================*/
        $project = Proyect::where('id', $projectId)->update([
            'category_id' => $category->id,
            'state' => count($curadorCategory) > 0 ? Proyect::ACEPTED : Proyect::SUBSANADO
        ]);
        /*=============================================
            ASIGNAMOS QUE SUBSANADOR LO ASIGNO
        =============================================*/
        $subsanadorId = Subsanador::where('user_id', $currentUserId)->first();

        $subsanador = DB::table('subsanador_projects')
            ->insert([
                'subsanador_id' => $subsanadorId->id,
                'proyect_id' => $projectId
            ]);


        return response()->json('Se actualizó correctamente', 200);
    }

    public function updateEditProjectDb($id)
    {
        $project = Proyect::where('id', $id)->first();
        $project->update([
            'edit' => $project->edit === 0 ? 1 : 0
        ]);
        return response()->json('Esta siendo editado');
    }

    public function assignProjectsMasive(Request $request)
    {
        $category = json_decode($request->category);
        /*=============================================
           BUSCAMOS CURADORES QUE TENGA LA CATEGORÍA RECIBIDA
       =============================================*/
        $curadorCategory = DB::table('curador_categories')
            ->where('category_id', $category->id)
            ->get();
        if (count($curadorCategory) === 0) return response()->json('No hay un curador asignado a la modalidad ' . $category->category, 401);
        /*=============================================
           BUSCAMOS LOS PROYECTOS QUE ESTE SIN CURADOR, QUE HAYAN SIDO SUBSANADOS Y QUE TENGAN ESA CATEGORÍA
       =============================================*/
        $projectsCategory = Proyect::where([['category_id', $category->id], ['state', Proyect::SUBSANADO]])->get();
        if (count($projectsCategory) === 0) return response()->json('No hay proyectos relacionados a esta modalidad ó ya fueron asignados', 401);


        $projectsCount = $projectsCategory->count();
        $curadorsCount = $curadorCategory->count();
        $numberProjectCurador = intval(round($projectsCount / $curadorsCount, 0));
        if ($numberProjectCurador < 1) {
            $numberProjectCurador++;
        }
        $response = [
            'total' => $numberProjectCurador,
            'curadores' => $curadorsCount,
            'proyectos' => $projectsCount,
        ];
        Log::error('MENSAJE LOG.', $response);

        $recorrer = 0;
        $j = 0;

        for ($i = 0; $i < $curadorsCount;) {

            if ($j < $projectsCount) {
                Log::info('INSERTS.');
                Log::info($curadorCategory[$i]->curador_id);
                Log::info($projectsCategory[$j]->id);
                $curadorProject = DB::table('curador_projects')
                    ->insert([
                        'curador_id' => $curadorCategory[$i]->curador_id,
                        'proyect_id' => $projectsCategory[$j]->id
                    ]);
                /*=============================================
                    ACTUALIZAMOS LA CATEGORÍA DEL PROYECTO
                 =============================================*/
                $project = Proyect::where('id', $projectsCategory[$j]->id)->update([
                    'state' => Proyect::ACEPTED
                ]);
            }

            $recorrer = $recorrer + 1;
            if ($numberProjectCurador == $recorrer) {
                $i++;
                $recorrer = 0;
            }
            $j++;
        }
        return response()->json('Se asignaron correctamente', 200);
    }

    public function countNeedSubsanar(){
        $countNeedSubsanar = Proyect::where('state', 2)->count();
        return response()->json(['data'=>$countNeedSubsanar]);
    }
    public function countAlreadySubsanar(){
        $countAlreadySubsanar = Proyect::where('state', 8)->count();
        return response()->json(['data'=>$countAlreadySubsanar]);
    }
    public function countCuradorSubsanar(){
        $countCuradorSubsanar = Proyect::where('state', 3)->count();
        return response()->json(['data'=>$countCuradorSubsanar]);
    }
}
