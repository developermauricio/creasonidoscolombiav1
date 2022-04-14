<?php

namespace App\Http\Controllers\Aspirant;

use App\Http\Controllers\Controller;
use App\Mail\Aspirant\EndTimeProject;
use App\Models\Aspirant;
use App\Models\Minor;
use App\Models\Proyect;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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
        if ($success === true) {
            DB::commit();
            return response()->json('Proyecto actualizado correctamente', 200);
        } else {
            return response()->json('Error al realizar la transacción', 500);
        }

    }

    public function editProfile(Request $request)
    {
        /*=============================================
            DATOS PERSONALES
        =============================================*/
        $user_id = $request->user_id;
        $aspirant_id = $request->aspirant_id;
        $aspirantType = $request->aspirant_type;
        $name = $request->name;
        $last_name = $request->last_name;
        $email = $request->email;
        $phone = $request->phone;
        $birthday = $request->birthday;
        $address = $request->address;
        $headHousehold = $request->headHousehold;
        $victimConflict = $request->victimConflict;
        $disability = $request->disability;
        $acceptTerm = $request->acceptTerm;
        $genero = json_decode($request->genero);
        $ethnic = json_decode($request->ethnic_id);
        $city = json_decode($request->city);
        $archive = $request->archive;
        $extension_archive = $request->extension_archive;

        /*=============================================
               DATOS DEL PROYECTO
       =============================================*/
        $project_id = $request->project_id;
        $project_name = $request->project_name;
        $project_name_author = $request->project_name_author;
        $project_description = $request->project_description;
        $project_category = json_decode($request->project_category);
        $project_audio = $request->project_audio;

        /*=============================================
                ACTUALIZAMOS EL USUARIO
        =============================================*/
        $user = User::where('id', $user_id)->update([
            'name' => ucwords($name),
            'last_name' => ucwords($last_name),
            'email' => $email,
            'phone' => $phone,
            'birthday' => $birthday,
            'address' => $address,
            'gender_id' => $genero->id,
            'city_id' => $city->id,
            'slug' => Str::slug($name . '-' . $last_name . Str::random(10))
        ]);

        /*=============================================
                    ACTUALIZAMOS EL ASPIRANTE
            =============================================*/
        $aspirant = Aspirant::where('id', $aspirant_id)->update([
            'has_project' => 1,
            'accept_termi' => $acceptTerm,
            'cc_document' => $archive,
            'extension_document' => $extension_archive,
            'user_id' => $user_id,
            'aspirant_type_id' => $aspirantType,
            'ethnic_id' => $ethnic->id,
            'head_house_hold' => $headHousehold,
            'victim_conflict' => $victimConflict,
            'disability' => $disability,
        ]);

        /*=============================================
                    DATOS DEL MENOR DE EDAD
            =============================================*/
        if ($aspirantType === '3') {
            $minor_id = $request->minor_id;
            $name_minor = $request->name_minor;
            $birthday_minor = $request->birthday_minor;
            $last_name_minor = $request->last_name_minor;
            $document_minor = $request->document_minor;
            $extension_document_minor = $request->extension_document_minor;

            Minor::where('id', $minor_id)->update([
                'name' => ucwords($name_minor),
                'last_name' => ucwords($last_name_minor),
                'birthday' => $birthday_minor,
                'document' => $document_minor,
                'extension_document' => $extension_document_minor
            ]);
        }

        /*=============================================
                    CREAMOS EL PROYECTO
            =============================================*/
        $project = Proyect::where('id', $project_id)->update([
            'title' => ucwords($project_name),
            'name_author' => ucwords($project_name_author),
            'description' => $project_description,
            'category_id' => $project_category->id,
            'audio' => $project_audio,
            'slug' => Str::slug($project_name . '-' . Str::random(10))
        ]);
    }
}
