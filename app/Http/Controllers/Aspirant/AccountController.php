<?php

namespace App\Http\Controllers\Aspirant;

use App\Http\Controllers\Controller;
use App\Mail\Aspirant\AccountCreate;
use App\Models\Aspirant;
use App\Models\AspirantProyect;
use App\Models\Curador;
use App\Models\Proyect;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function createAccount(Request $request)
    {
        $name = $request->get('name');
        $lastName = $request->get('last_name');
        $email = $request->get('email');

        $password = Str::random(8);
        $pass = bcrypt($password);
        $success = true;

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => ucwords($name),
                'last_name' => ucwords($lastName),
                'email' => $email,
                'password' => $pass
            ]);
            Aspirant::create([
                'user_id' => $user->id
            ]);
            $user->roles()->attach('2');
            auth()->logout();
            DB::commit();

        } catch (\Throwable $th) {
            $success = $th->getMessage();
            DB::rollBack();
            $response = [
                'msg' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('Error al crear la cuenta.', $response);
            return response()->json($response, 501);
        }
        try {
            Mail::to($email)->send(new AccountCreate(ucwords($name), ucwords($lastName), $password, $email));
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'msg' => 'Error al enviar el correo electrónico',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('Error al enviar correos.', $response);
            return response()->json($response, 501);
        }

        return response()->json('Transacción realizada exitosamente', 201);
    }

    /* Consultas para los reportes */
    public function getAllAspirantsRegisters() {
        $listAspirant = AspirantProyect::with('project', 
            'aspirant', 
            'aspirant.user', 
            'aspirant.user.gender', 
            'aspirant.user.city', 
            'aspirant.user.city.departament', 
            'aspirant.aspirant_type', 
            'aspirant.ethnic', 
            'aspirant.categoryAspirant')->get();
        /* $listAspirant = Aspirant::with('user')
            ->get(); */
        //Log::debug('consulta...');
        //Log::debug($listAspirant[0]["aspirant"]["created_at"]);
        //$newDate = new Carbon($listAspirant[0]["aspirant"]["created_at"], 'America/Bogota');
        //Log::debug($newDate->toDateTimeString());
        return response()->json(['status' => 'ok', 'data' => $listAspirant]);
    }

    public function getAllAspirants() {
        //$listAspirant = Aspirant::with('user', 'user.gender', 'user.city', 'user.city.departament', 'aspirant_type', 'ethnic', 'categoryAspirant')
        $listAspirant = Aspirant::with('user', 'aspirantType')
            //->where('aspirant_type_id', '<>', null)
            ->where('id', '>', 120)
            ->get();
        return response()->json(['status' => 'ok', 'data' => $listAspirant]);
    }

    public function getAllAspirantsLocation() {
        $listAspirant = Aspirant::with('user', 'user.city', 'user.city.departament')
            ->where('aspirant_type_id', '<>', null)
            ->get();

        return response()->json(['status' => 'ok', 'data' => $listAspirant]);
    }

    public function getAllCuradors() {
        $listCuradors = Curador::with('user', 'categories')->withCount('projects')
            ->get();
        return response()->json(['status' => 'ok', 'data' => $listCuradors]);
    }

    public function getAllProjects() {
        $listProjects = Proyect::with('category')->get();
        return response()->json(['status' => 'ok', 'data' => $listProjects]);
    }

    public function getAllCuradorProject() {
        $listProjects = Proyect::with('category')->get();
        return response()->json(['status' => 'ok', 'data' => $listProjects]);
    }
}
