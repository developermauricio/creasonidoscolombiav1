<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minor extends Model
{
    protected  $fillable = [
        'document',
        'extension_document',
        'name',
        'last_name',
        'birthday',
        'parent_id'
    ];

    public function parent(){
        $this->hasOne(ParentApirant::class, 'parent_id');
    }
}
