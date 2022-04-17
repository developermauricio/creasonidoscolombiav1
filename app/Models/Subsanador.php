<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subsanador extends Model
{
    public function projects()
    {
        return $this->belongsToMany(
            Proyect::class,
            'subsanador_projects',
            'subsanador_id',
            'proyect_id'
        );
    }
}
