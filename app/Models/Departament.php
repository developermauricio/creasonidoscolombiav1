<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
    protected $fillable = [

        'codigo',
        'descripcion',
        'idZona'
    ];
}
