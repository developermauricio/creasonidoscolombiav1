<?php

namespace App\Models;

use App\CategoryAspirant;
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
        'cc_document_pdf',
        'cc_document_frontal',
        'cc_document_back',
        'accept_termi',
        'extension_document',
        'biography',
        'user_id',
        'aspirant_type_id',
        'head_house_hold',
        'victim_conflict',
        'disability',
        'category_aspirant_id',
        'vinculado_ecopetrol',
        'primer_empleo_ecopetrol',
        'bachilleres_colombia_ecopetrol',
    ];

    public function projects(){
        return $this->belongsToMany(Proyect::class, 'aspirant_proyects', 'aspirant_id', 'proyect_id');
    }

    public function ethnic(){
        return $this->belongsTo(Ethnic::class, 'ethnic_id');
    }

    public function categoryAspirant(){
        return $this->belongsTo(CategoryAspirant::class, 'category_aspirant_id');
    }

    public function aspirant_type(){
        return $this->belongsTo(AspirantType::class, 'aspirant_type_id');
    }

    public function parent(){
        return $this->hasOne(ParentApirant::class, 'aspirant_id');
    }

    static public function getDataAspirant($id){
        $aspirant = Aspirant::where('user_id', $id)->with('user.gender', 'user.city.departament', 'aspirant_type', 'projects.category', 'parent.minor', 'ethnic', 'categoryAspirant')->first();
        return $aspirant;
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aspirantType() {
        return $this->belongsTo(AspirantType::class, 'aspirant_type_id');
    }
}
