<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'codigo',
        'iddepartamento',
        'descripcion'
    ];


    public function departament() {
        return $this->belongsTo(Departament::class, 'iddepartamento');
    }
}
