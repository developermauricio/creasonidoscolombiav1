<?php

namespace App\Http\Controllers\Aspirant;

use App\Http\Controllers\Controller;
use App\Mail\Aspirant\RegisterProject;
use App\Models\Aspirant;
use App\Models\AspirantType;
use App\Models\Minor;
use App\Models\ParentApirant;
use App\Models\Proyect;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index()
    {
        return view('aspirant.register');
    }

    public function getAspirantType()
    {
        $aspirantType = AspirantType::all();
        return response()->json(['data' => $aspirantType]);
    }

    public function uploadArchiveMinor(Request $request)
    {
        $nameAspirant = $request->input('nameMinor');
        $documentAspirant = $request->input('documentMinor');
        $uuid = $request->input('archiveUuid');
        $archive = $request->file('archive');
        $archiveExtension = $archive->getClientOriginalExtension();
        $ramdon = Str::random(10);
        $nameArchive = Str::slug(strtolower($nameAspirant) . '-' . Str::random(15), '-');
        $path = Storage::disk('public')->put('/archives/' . $nameArchive . '.' . $archiveExtension, file_get_contents($archive));

        $urlFinal = '/storage/archives/' . $nameArchive . '.' . $archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function removedArchiveMinor(Request $request)
    {
        $pathArchive = $request->get('archiveMinor');
        $partes_ruta = pathinfo($pathArchive);
        Storage::delete('archives/' . $partes_ruta['basename']);

        return response()->json('Se eliminó correctamente');
    }

    public function uploadArchiveAspirant(Request $request)
    {
//        $editAspirant = $request->input('editAspirant');
//
//        if ($editAspirant){
//            $pathArchive = $request->get('documentAspirant');
//            $partes_ruta = pathinfo($pathArchive);
//            Storage::delete('archives/' . $partes_ruta['basename']);
//        }

        $nameAspirant = $request->input('nameAspirant');
        $documentAspirant = $request->input('documentAspirant');
        $uuid = $request->input('archiveUuid');
        $archive = $request->file('archive');
        $archiveExtension = $archive->getClientOriginalExtension();
        $ramdon = Str::random(10);
        $nameArchive = Str::slug(strtolower($nameAspirant) . '-' . Str::random(15), '-');
        $path = Storage::disk('public')->put('/archives/' . $nameArchive . '.' . $archiveExtension, file_get_contents($archive));

        $urlFinal = '/storage/archives/' . $nameArchive . '.' . $archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function removedArchiveAspirant(Request $request)
    {
        $pathArchive = $request->get('archiveArtist');
        $partes_ruta = pathinfo($pathArchive);
        Storage::delete('archives/' . $partes_ruta['basename']);

        return response()->json('Se eliminó correctamente');
    }

    public function uploadArchiveMusic(Request $request)
    {

        $nameProject = $request->input('nameProject');
        $nameAspirant = $request->input('nameAspirant');
        $uuid = $request->input('archiveUuid');
        $archive = $request->file('archiveMusic');
        $archiveExtension = $archive->getClientOriginalExtension();
        $nameArchive = Str::slug(strtolower($nameProject) . '-' . strtolower($nameAspirant) . '-' . strtolower($archive->getClientOriginalName()) . '-' . 'principal' . '-' . Str::random(10), '-');
        $path = Storage::disk('public')->put('/projects/' . $nameArchive . '.' . $archiveExtension, file_get_contents($archive));

        $urlFinal = '/storage/projects/' . $nameArchive . '.' . $archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function removedArchiveMusicPrincipal(Request $request)
    {
        $pathArchive = $request->get('archiveMusicPrincipal');
        $partes_ruta = pathinfo($pathArchive);
        Storage::delete('projects/' . $partes_ruta['basename']);

        return response()->json('Se eliminó correctamente');
    }

    public function uploadArchiveMusicOpcional(Request $request)
    {

        $nameAspirant = $request->input('nameAspirant');
        $documentAspirant = $request->input('documentAspirant');
        $uuid = $request->input('archiveUuid');
        $archive = $request->file('archiveMusicOpcional');
        $archiveExtension = $archive->getClientOriginalExtension();
        $nameArchive = $documentAspirant . '-' . strtolower($nameAspirant) . '-' . strtolower($archive->getClientOriginalName()) . '-' . 'opcional' . '-' . Str::random(10);
        $path = Storage::disk('public')->put('/projects/' . $nameArchive . '.' . $archiveExtension, file_get_contents($archive));

        $urlFinal = '/storage/projects/' . $nameArchive . '.' . $archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function removedArchiveMusicOpcional(Request $request)
    {
        $pathArchive = $request->get('archiveMusicOpcional');
        $partes_ruta = pathinfo($pathArchive);
        Storage::delete('projects/' . $partes_ruta['basename']);

        return response()->json('Se eliminó correctamente');
    }

    public function createRegister(Request $request)
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
        $acceptTerm = $request->acceptTerm;
        $genero = json_decode($request->genero);
        $city = json_decode($request->city);
        $archive = json_decode($request->archive);

        /*=============================================
                DATOS DEL PROYECTO
        =============================================*/
        $project_name = $request->project_name;
        $project_name_author = $request->project_name_author;
        $project_description = $request->project_description;
        $project_category = json_decode($request->project_category);
        $project_audio = json_decode($request->project_audio);

        /*=============================================
           NUEVA CONTRASEÑA
        =============================================*/
        $password = $request->password;
        $pass = bcrypt($password);
        /*=============================================
                ACTUALIZAMOS EL USUARIO
        =============================================*/
        $success = true;
        DB::beginTransaction();
        try {
            $user = User::where('id', $user_id)->update([
                'name' => ucwords($name),
                'last_name' => ucwords($last_name),
                'email' => $email,
                'phone' => $phone,
                'password' => $pass,
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
                'cc_document' => $archive[0]->urlArchive,
                'extension_document' => $archive[0]->extension,
                'user_id' => $user_id,
                'aspirant_type_id' => $aspirantType,
            ]);

            /*=============================================
               DATOS SI ES REPRESENTANTE DE UN MENOR DE EDAD
            =============================================*/
            if ($aspirantType === "3") {

                $document_minor = json_decode($request->archive_minor);
                $name_minor = $request->name_minor;
                $last_name_minor = $request->last_name_minor;
                $birthday_minor = $request->birthday_minor;

                $parent = ParentApirant::create([
                    'user_id' => $user_id,
                    'aspirant_id' => $aspirant_id
                ]);

                $minor = Minor::create([
                    'document' => $document_minor[0]->urlArchive,
                    'extension_document' => $document_minor[0]->extension,
                    'name' => ucwords($name_minor),
                    'last_name' => ucwords($last_name_minor),
                    'birthday' => $birthday_minor,
                    'parent_id' => $parent->id
                ]);
            }


            /*=============================================
                    CREAMOS EL PROYECTO
            =============================================*/
            $project = Proyect::create([
                'title' => ucwords($project_name),
                'name_author' => ucwords($project_name_author),
                'description' => $project_description,
                'category_id' => $project_category->id,
                'audio' => $project_audio[0]->urlArchive,
                'end_time' => Carbon::now()->addDay(),
                'slug' => Str::slug($project_name . '-' . Str::random(10))
            ]);

            $project->aspirant()->attach($aspirant_id);
            Mail::to($email)->send(new RegisterProject($email, $name, $last_name, ucwords($project_name), $project_category->category));
        } catch (\Exception $exception) {
            $success = $exception->getMessage();
        }
        if ($success === true) {
            DB::commit();
            return response()->json('Transacción realizada exitosamente', 200);
        } else {
            return response()->json('Error al realizar la transacción', 500);

        }
    }
}
