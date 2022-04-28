<?php

namespace App\Models;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Proyect extends Model
{

    const BORRADOR = 1;
    const REVISION = 2;
    const ACEPTED = 3;
    const QUALIFIED = 4;
    const REJECTED = 5;
    const APPROVAL = 6;
    const PENDING_REGISTER = 7;
    const SUBSANADO = 8;

    const AVAILABLE_TO_EDIT = 1;
    const NOT_AVAILABLE_TO_EDIT = 2;

    protected $fillable = [

        'title',
        'description',
        'state',
        'audio',
        'name_author',
        'slug',
        'end_time',
        'category_id',
        'category_by_aspirant',
        'available_edit'
    ];

    public function aspirant(){
        return $this->belongsToMany(Aspirant::class, 'aspirant_proyects', 'proyect_id', 'aspirant_id');
    }

    public function curador(){
        return $this->belongsToMany(Curador::class, 'curador_projects', 'proyect_id', 'curador_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

   
}
