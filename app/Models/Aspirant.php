<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Aspirant extends Model
{
    const HAS_PROJECT = 1;
    const NOT_HAS_PROJECT = 2;

    const CUENTA_CON_CANCIONES_INEDITAS = 1;
    const ACEPTA_COMPOSITORES_CREA_SONIDOS = 2;

    protected $fillable = [
        'has_project',
        'cc_document',
        'accept_termi',
        'extension_document',
        'biography',
        'user_id',
        'aspirant_type_id'
    ];

    public function projects(){
        return $this->belongsToMany(Proyect::class, 'aspirant_proyects', 'aspirant_id', 'proyect_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function aspirant_type(){
        return $this->belongsTo(AspirantType::class, 'aspirant_type_id');
    }

    static public function getDataAspirant($id){
        $aspirant = Aspirant::where('user_id', $id)->with('user.gender', 'user.city.departament', 'aspirant_type', 'projects.category')->first();
        return $aspirant;
    }
}
