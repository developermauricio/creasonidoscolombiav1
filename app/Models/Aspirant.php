<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirant extends Model
{
    const HAS_PROJECT = 1;
    const NOT_HAS_PROJECT = 2;

    protected $fillable = [
        'has_project',
        'cc_pdf',
        'biography',
        'user_id',
        'aspirant_type_id'
    ];

    public function projects(){
        return $this->belongsToMany(Proyect::class, 'aspirant_proyects', 'aspirant_id', 'proyect_id');

    }
}
