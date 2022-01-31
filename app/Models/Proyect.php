<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proyect extends Model
{

    const BORRADOR = 1;
    const REVISION = 2;
    const ACEPTED = 3;
    const REJECTED = 4;
    const APPROVAL = 5;
    const PENDING_REGISTER = 6;

    protected $fillable = [

        'tittle',
        'description',
        'status',
        'audio',
        'slug',
        'end_time',
        'categories_id'
    ];
}
