<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Curador extends Model
{
    protected $table = 'curadors';
    protected $fillable = ['biography', 'categories_id', 'user_id'];

    public function projects()
    {
        return $this->belongsToMany(
            Proyect::class,
            'curador_projects',
            'curador_id',
            'proyect_id'
        );
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}
