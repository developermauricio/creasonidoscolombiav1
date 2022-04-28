<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AspirantProyect extends Model
{
    protected $fillable = [
        'aspirant_id',
        'proyect_id'
    ];

    public function project(){
        return $this->belongsTo(Proyect::class, 'proyect_id');
    }

    public function aspirant() {
        return $this->belongsTo(Aspirant::class, 'aspirant_id');
    }
}
