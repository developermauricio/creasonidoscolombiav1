<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minor extends Model
{
    protected  $fillable = [
        'document_pdf',
        'document_photo_frontal',
        'document_photo_back',
        'name',
        'last_name',
        'birthday',
        'parent_id'
    ];

    public function parent(){
        $this->hasOne(ParentApirant::class, 'parent_id');
    }
}
