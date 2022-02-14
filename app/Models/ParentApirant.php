<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentApirant extends Model
{
    protected  $fillable = [
        'user_id',
        'aspirant_id'
    ];

    public function minor(){
        return $this->hasOne(Minor::class, 'parent_id');
    }
}
