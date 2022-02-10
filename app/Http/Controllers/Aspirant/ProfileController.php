<?php

namespace App\Http\Controllers\Aspirant;

use App\Http\Controllers\Controller;
use App\Mail\Aspirant\EndTimeProject;
use App\Models\Aspirant;
use App\Models\Proyect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    public function index()
    {

        return view('aspirant.profile');
    }

    public function udpateStateProject($id)
    {

        $project = Proyect::where('id', $id)->with('aspirant.user', 'category')->first();
        $email = $project->aspirant[0]->user->email;
        $name = $project->aspirant[0]->user->name;
        $last_name = $project->aspirant[0]->user->last_name;
        $project_name = $project->title;
        $project_category = $project->category->category;

        $success = true;

        DB::beginTransaction();
        try {
            Proyect::where('id', $id)->update([
                'state' => 2,
                'available_edit' => 2
            ]);
            Mail::to($email)->send(new EndTimeProject($email, $name, $last_name, $project_name, $project_category));

        } catch (\Exception $exception) {
            $success = $exception->getMessage();
        }
        if ($success === true){
            DB::commit();
            return response()->json('Proyecto actualizado correctamente', 200);
        }else{
            return response()->json('Error al realizar la transacción', 500);
        }

    }
}
