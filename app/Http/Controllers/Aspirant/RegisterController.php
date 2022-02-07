<?php

namespace App\Http\Controllers\Aspirant;

use App\Http\Controllers\Controller;
use App\Models\AspirantType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function index(){
        return view('aspirant.register');
    }

    public function getAspirantType(){
        $aspirantType = AspirantType::all();
        return response()->json(['data'=>$aspirantType]);
    }

    public function uploadArchiveAspirant(Request $request)
    {

        $nameAspirant = $request->input('nameAspirant');
        $documentAspirant = $request->input('documentAspirant');
        $uuid = $request->input('archiveUuid');
        $archive = $request->file('archive');
        $archiveExtension = $archive->getClientOriginalExtension();
        $ramdon = Str::random(10);
        $nameArchive = strtolower($nameAspirant) .'-'. Str::random(15);
        $path = Storage::disk('public')->put('/archives/' . $nameArchive.'.'.$archiveExtension, file_get_contents($archive));

        $urlFinal = '/storage/archives/' . $nameArchive .'.'.$archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function removedArchiveAspirant(Request $request)
    {
        $pathArchive = $request->get('archiveArtist');
        $partes_ruta = pathinfo($pathArchive);
        Storage::delete('archives/' . $partes_ruta['basename']);

        return response()->json('Se eliminó correctamente');
    }

    public function uploadArchiveMusic(Request $request){
        $nameProject = $request->input('nameProject');
        $nameAspirant = $request->input('nameAspirant');
        $uuid = $request->input('archiveUuid');
        $archive = $request->file('archiveMusic');
        $archiveExtension = $archive->getClientOriginalExtension();
        $nameArchive = strtolower($nameProject).'-'.strtolower($nameAspirant).'-'.strtolower($archive->getClientOriginalName()).'-'.'principal'.'-'.Str::random(10);
        $path = Storage::disk('public')->put('/projects/' . $nameArchive.'.'.$archiveExtension, file_get_contents($archive));

        $urlFinal = '/storage/projects/' . $nameArchive .'.'.$archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function removedArchiveMusicPrincipal(Request $request){
        $pathArchive = $request->get('archiveMusicPrincipal');
        $partes_ruta = pathinfo($pathArchive);
        Storage::delete('projects/' . $partes_ruta['basename']);

        return response()->json('Se eliminó correctamente');
    }

    public function uploadArchiveMusicOpcional(Request $request){

        $nameAspirant = $request->input('nameAspirant');
        $documentAspirant = $request->input('documentAspirant');
        $uuid = $request->input('archiveUuid');
        $archive = $request->file('archiveMusicOpcional');
        $archiveExtension = $archive->getClientOriginalExtension();
        $nameArchive = $documentAspirant. '-' . strtolower($nameAspirant).'-'.strtolower($archive->getClientOriginalName()).'-'.'opcional'.'-'.Str::random(10);
        $path = Storage::disk('public')->put('/projects/' . $nameArchive.'.'.$archiveExtension, file_get_contents($archive));

        $urlFinal = '/storage/projects/' . $nameArchive .'.'.$archiveExtension;
        return response()->json(['data' => $urlFinal, 'uuid' => $uuid, 'extension' => $archiveExtension]);
    }

    public function removedArchiveMusicOpcional(Request $request){
        $pathArchive = $request->get('archiveMusicOpcional');
        $partes_ruta = pathinfo($pathArchive);
        Storage::delete('projects/' . $partes_ruta['basename']);

        return response()->json('Se eliminó correctamente');
    }
}
