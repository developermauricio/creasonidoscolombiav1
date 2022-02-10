<?php

namespace App\Models;

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

    protected $fillable = [

        'title',
        'description',
        'state',
        'audio',
        'slug',
        'end_time',
        'categories_id'
    ];

    public function aspirant(){
        return $this->belongsToMany(Aspirant::class, 'aspirant_proyects', 'proyect_id', 'aspirant_id');
    }

    public function curador(){
        return $this->belongsToMany(Curador::class, 'curador_projects', 'proyect_id', 'curador_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
