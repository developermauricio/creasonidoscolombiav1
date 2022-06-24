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
use Illuminate\Support\Facades\Log;
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
        $path = Storage::disk('s3')->putFileAs('/archives/document-pdf/minor/', $archive, $nameArchive . '.' . $archiveExtension, 'public');

        $urlFinal = env('AWS_URL_ARCHIVE_PDF_MINOR') . $nameArchive . '.' . $archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function uploadArchiveMinorPhotoFrontal(Request $request)
    {
        $nameAspirant = $request->input('nameAspirant');
        $uuid = $request->input('archiveUuid');
        $archive = $request->file('archive');
        $archiveExtension = $archive->getClientOriginalExtension();
        $ramdon = Str::random(10);
        $nameArchive = Str::slug(strtolower($nameAspirant) . '-' .'frontal'.'-'.Str::random(15), '-');
        $path = Storage::disk('s3')->putFileAs('/archives/document-photo/minor/', $archive, $nameArchive . '.' . $archiveExtension, 'public');

        $urlFinal = env('AWS_URL_ARCHIVE_PHOTO_MINOR') . $nameArchive . '.' . $archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function uploadArchiveMinorPhotoBack(Request $request)
    {

        $nameAspirant = $request->input('nameAspirant');
        $uuid = $request->input('archiveUuid');
        $archive = $request->file('archive');
        $archiveExtension = $archive->getClientOriginalExtension();
        $ramdon = Str::random(10);
        $nameArchive = Str::slug(strtolower($nameAspirant) . '-' .'back'.'-'.Str::random(15), '-');
        $path = Storage::disk('s3')->putFileAs('/archives/document-photo/minor/', $archive, $nameArchive . '.' . $archiveExtension, 'public');

        $urlFinal = env('AWS_URL_ARCHIVE_PHOTO_MINOR'). $nameArchive . '.' . $archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function removedArchiveMinorPhotoFrontal(Request $request)
    {
        $pathArchive = $request->get('archiveArtistPhotoFrontal');
        $partes_ruta = pathinfo($pathArchive);
        Storage::disk('s3')->delete('archives/document-photo/minor/' . $partes_ruta['basename']);

        return response()->json('Se eliminó correctamente');
    }
    public function removedArchiveMinorPhotoBack(Request $request)
    {
        $pathArchive = $request->get('archiveArtistPhotoBack');
        $partes_ruta = pathinfo($pathArchive);
        Storage::disk('s3')->delete('archives/document-photo/minor/' . $partes_ruta['basename']);
        return response()->json('Se eliminó correctamente');
    }

    public function removedArchiveMinor(Request $request)
    {
        $pathArchive = $request->get('archiveMinor');
        $partes_ruta = pathinfo($pathArchive);
        Storage::disk('s3')->delete('archives/document-pdf/minor/' . $partes_ruta['basename']);

        return response()->json('Se eliminó correctamente');
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
        $path = Storage::disk('s3')->putFileAs('/archives/document-pdf/', $archive,$nameArchive . '.' . $archiveExtension, 'public');

        $urlFinal = env('AWS_URL_ARCHIVE_ASPIRANT_DOCUMENT_PDF') . $nameArchive . '.' . $archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function uploadArchiveAspirantPhotoFrontal(Request $request)
    {

        $nameAspirant = $request->input('nameAspirant');
        $uuid = $request->input('archiveUuid');
        $archive = $request->file('archive');
        $archiveExtension = $archive->getClientOriginalExtension();
        $ramdon = Str::random(10);
        $nameArchive = Str::slug(strtolower($nameAspirant) . '-' .'frontal'.'-'.Str::random(15), '-');
        $path = Storage::disk('s3')->putFileAs('/archives/document-photo/', $archive,$nameArchive . '.' . $archiveExtension, 'public');

        $urlFinal = env('AWS_URL_ARCHIVE_ASPIRANT_DOCUMENT_PHOTO'). $nameArchive . '.' . $archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }
    public function uploadArchiveAspirantPhotoBack(Request $request)
    {

        $nameAspirant = $request->input('nameAspirant');
        $uuid = $request->input('archiveUuid');
        $archive = $request->file('archive');
        $archiveExtension = $archive->getClientOriginalExtension();
        $ramdon = Str::random(10);
        $nameArchive = Str::slug(strtolower($nameAspirant) . '-' .'back'.'-'.Str::random(15), '-');
        $path = Storage::disk('s3')->putFileAs('/archives/document-photo/', $archive, $nameArchive . '.' . $archiveExtension, 'public');

        $urlFinal = env('AWS_URL_ARCHIVE_ASPIRANT_DOCUMENT_PHOTO') . $nameArchive . '.' . $archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function removedArchivePhotoFrontal(Request $request)
    {
        $pathArchive = $request->get('archiveArtistPhotoFrontal');
        $partes_ruta = pathinfo($pathArchive);
        Storage::disk('s3')->delete('archives/document-photo/' . $partes_ruta['basename']);

        return response()->json('Se eliminó correctamente');
    }
    public function removedArchivePhotoBack(Request $request)
    {
        $pathArchive = $request->get('archiveArtistPhotoBack');
        $partes_ruta = pathinfo($pathArchive);
        Storage::disk('s3')->delete('archives/document-photo/' . $partes_ruta['basename']);
        return response()->json('Se eliminó correctamente');
    }
    public function removedArchivePdf(Request $request)
    {
        $pathArchive = $request->get('archiveArtist');
        $partes_ruta = pathinfo($pathArchive);
        Storage::disk('s3')->delete('archives/document-pdf/' . $partes_ruta['basename']);

        return response()->json('Se eliminó correctamente');
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
        $path = Storage::disk('s3')->putFileAs('/projects/', $archive,  $nameArchive . '.' . $archiveExtension, 'public');

        $urlFinal = env('AWS_URL_PROJECT'). $nameArchive . '.' . $archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function removedArchiveMusicPrincipal(Request $request)
    {
        $pathArchive = $request->get('archiveMusicPrincipal');
        $partes_ruta = pathinfo($pathArchive);
//        Storage::delete('projects/' . $partes_ruta['basename']);
        Storage::disk('s3')->delete('projects/' . $partes_ruta['basename']);

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
        $headHousehold = $request->headHousehold;
        $victimConflict = $request->victimConflict;
        $disability = $request->disability;
        $acceptTerm = $request->acceptTerm;
        $genero = json_decode($request->genero);
        $ethnic = json_decode($request->ethnic_id);
        $category_aspirant = json_decode($request->category_aspirant_id);
        $city = json_decode($request->city);
        $archive = json_decode($request->archive);
        $archiveDocumentPhotoFrontal = json_decode($request->archiveDocumentPhotoFrontal);
        $archiveDocumentPhotoBack = json_decode($request->archiveDocumentPhotoBack);
        $vinculado_ecopetrol = $request->vinculado_ecopetrol;
        $primer_empleo_ecopetrol = $request->primer_empleo_ecopetrol;
        $bachilleres_colombia_ecopetrol = $request->bachilleres_colombia_ecopetrol;

        /*=============================================
                DATOS DEL PROYECTO
        =============================================*/
        $project_name = $request->project_name;
        $project_name_author = $request->project_name_author;
        $project_description = $request->project_description;
        $project_category = json_decode($request->project_category);
        $project_category_by_aspirant = $request->project_category_by_aspirant;
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
                'cc_document_pdf' => $archive ? $archive[0]->urlArchive : null,
                'cc_document_frontal' => $archiveDocumentPhotoFrontal ? $archiveDocumentPhotoFrontal[0]->urlArchive : null,
                'cc_document_back' => $archiveDocumentPhotoBack ? $archiveDocumentPhotoBack[0]->urlArchive : null,
//                'extension_document' => $archive[0]->extension,
                'user_id' => $user_id,
                'aspirant_type_id' => $aspirantType,
                'ethnic_id' => $ethnic->id,
                'category_aspirant_id' => $category_aspirant->id,
                'head_house_hold' => $headHousehold,
                'victim_conflict' => $victimConflict,
                'disability' => $disability,
                'vinculado_ecopetrol' => $vinculado_ecopetrol,
                'primer_empleo_ecopetrol' => $primer_empleo_ecopetrol,
                'bachilleres_colombia_ecopetrol' => $bachilleres_colombia_ecopetrol,
            ]);

            /*=============================================
               DATOS SI ES REPRESENTANTE DE UN MENOR DE EDAD
            =============================================*/
            if ($aspirantType === "3") {

                $document_minor_pdf = json_decode($request->archive_minor);
                $document_minor_photo_frontal = json_decode($request->archiveDocumentMinorPhotoFrontal);
                $document_minor_photo_back = json_decode($request->archiveDocumentMinorPhotoBack);
                $name_minor = $request->name_minor;
                $last_name_minor = $request->last_name_minor;
                $birthday_minor = $request->birthday_minor;

                $parent = ParentApirant::create([
                    'user_id' => $user_id,
                    'aspirant_id' => $aspirant_id
                ]);

                $minor = Minor::create([
                    'document_pdf' => $document_minor_pdf ? $document_minor_pdf[0]->urlArchive : null,
                    'document_photo_frontal' => $document_minor_photo_frontal ? $document_minor_photo_frontal[0]->urlArchive : null,
                    'document_photo_back' => $document_minor_photo_back ? $document_minor_photo_back[0]->urlArchive : null,
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
                'category_id' => $project_category ? $project_category->id : null,
                'category_by_aspirant' => ucwords($project_category_by_aspirant),
                'audio' => $project_audio[0]->urlArchive,
                'end_time' => Carbon::now()->addDay(),
                'slug' => Str::slug($project_name . '-' . Str::random(10))
            ]);

            $project->aspirant()->attach($aspirant_id);
            Mail::to($email)->send(new RegisterProject($email, $name, $last_name, ucwords($project_name)));
        } catch (\Throwable $th) {
            $response = [
                'msg' => 'Registro Fallido',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('MENSAJE LOG.', $response);
            DB::rollBack();
            $success = false;
            return response()->json($response, 501);
        }
        if ($success === true) {
            DB::commit();
            return response()->json('Transacción realizada exitosamente', 200);
        } else {
            return response()->json('Error al realizar la transacción', 500);
        }
    }
}
