<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspirant extends Model
{
    protected $fillable = [

        'cc_pdf',
        'biography',
        'user_id',
        'aspirant_type_id'
    ];
}
