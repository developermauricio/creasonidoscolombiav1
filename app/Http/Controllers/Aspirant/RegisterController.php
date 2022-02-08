<?php

namespace App\Http\Controllers\Aspirant;

use App\Http\Controllers\Controller;
use App\Mail\Aspirant\RegisterProject;
use App\Models\Aspirant;
use App\Models\AspirantType;
use App\Models\Proyect;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    public function uploadArchiveAspirant(Request $request)
    {

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
        $nameArchive =  Str::slug(strtolower($nameProject) . '-' . strtolower($nameAspirant) . '-' . strtolower($archive->getClientOriginalName()) . '-' . 'principal' . '-' . Str::random(10), '-');
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
            'slug' => Str::slug($name.'-'.$last_name.Str::random(10))
        ]);
        /*=============================================
                ACTUALIZAMOS EL ASPIRANTE
        =============================================*/
        $aspirant = Aspirant::where('id', $aspirant_id)->update([
            'has_project' => 1,
            'cc_pdf' => $archive[0]->urlArchive,
            'user_id' => $user_id,
            'aspirant_type_id' => $aspirantType,
        ]);
        /*=============================================
                CREAMOS EL PROYECTO
        =============================================*/
        $dateNow = Carbon::now()->addDay();
        $dateHour =
        $project = Proyect::create([
            'title' => ucwords($project_name),
            'name_author' => ucwords($project_name_author),
            'description' => $project_description,
            'category_id' => $project_category->id,
            'audio' => $project_audio[0]->urlArchive,
            'end_time' => Carbon::now()->addDay(),
            'slug' => Str::slug($project_name.'-'.Str::random(10))
        ]);
        Mail::to($email)->send(new RegisterProject($email, $name, $last_name, $project_name, $project_category->category));

        return response()->json('Transacción realizada exitosamente', 200);
    }
}
