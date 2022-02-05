<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QualificationProject extends Model
{
    protected $fillable = [
        'lyric',
        'melody_rithyms',
        'arragements',
        'originality',
        'comment',
        'curadores_id',
        'proyect_id'
    ];

}
