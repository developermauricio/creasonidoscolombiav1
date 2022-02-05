<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Curador extends Model
{
    protected $fillable = [

        'biography',
        'categories_id',
        'user_id'
    ];

    public function projects(){
        return $this->belongsToMany(Proyect::class, 'curador_projects', 'curador_id', 'proyect_id');

    }
}
