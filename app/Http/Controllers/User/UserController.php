<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\User\UserCreate;
use App\Models\Curador;
use App\Models\Subsanador;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{

    public function index()
    {
        return view('user.user');
    }

    public function getUsers()
    {
        $user = User::role(['Administrador', 'Curador', 'Subsanador'])->with('roles')->get();
        return datatables()->of($user)->toJson();
    }

    public function createUser(Request $request)
    {
        $name = $request->name;
        $last_name = $request->last_name;
        $email = $request->email;
        $phone = $request->phone;
        $document = $request->document;
        $documentType = json_decode($request->document_type);
        $roles = json_decode($request->roles);

        $curador = $request->curador;
        $categories = json_decode($request->categories);
        $subsanador = $request->subsanador;

        $ramdon = Str::random(10);
        $password = Str::random(8);
        $pass = bcrypt($password);
        $slug = Str::slug($name . '-' . $last_name . '-' . $ramdon, '-');
        $success = true;
        try {
            $user = User::create([
                "name" => ucwords($name),
                "last_name" => ucwords($last_name),
                "email" => $email,
                "password" => $pass,
                "slug" => $slug,
                "phone" => $phone,
                "document_type_id" => $documentType->id,
                "document" => $document
            ]);
            foreach ($roles as $role) {
                $user->roles()->attach([$role->id]);
            }

            if ($curador === '1') {
                $categories = json_decode($request->categories);
                $biography = $request->biography_curador;
                $curadorDb = Curador::create([
                    "biography" => $biography,
                    "user_id" => $user->id
                ]);
                foreach ($categories as $category) {
                    $curadorDb->categories()->attach([$category->id]);
                }
            }
            if ($subsanador === '1') {
                $biography = $request->biography_subsanador;
                $subsanador = Subsanador::create([
                    "biography" => $biography,
                    "user_id" => $user->id
                ]);
            }

            Mail::to($email)->send(new UserCreate($email, ucwords($name), ucwords($last_name), $password));
        } catch (\Throwable $th) {
            DB::rollBack();
            $response = [
                'msg' => 'Registro Fallido',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('MENSAJE LOG.', $response);
            $success = false;
            return response()->json($response, 501);
        }
        if ($success === true) {
            DB::commit();
            return response()->json('Transacción realizada exitosamente', 200);
        } else {
            DB::rollBack();
            return response()->json('Error al realizar la transacción', 500);

        }
    }
    public function updatePasswordUser(Request $request){
        $pass = bcrypt($request->password);
        $currentUserId = $request->userId;
        $success = true;
        try {
        $user = User::where('id', $currentUserId)->update([
            'password' => $pass
        ]);
        } catch (\Throwable $th) {
            $response = [
                'msg' => 'Actualización Fallida',
                'error' => $th->getMessage(),
                'trace' => $th->getTraceAsString()
            ];
            Log::error('MENSAJE LOG.', $response);
            $success = false;
            return response()->json($response, 501);
        }
        if ($success === true) {
            DB::commit();
            return response()->json(['Contraseña actualizada correctamente']);
        } else {
            return response()->json('Error al realizar la actualización', 500);

        }
    }
}
