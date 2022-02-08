<?php

namespace App;

use App\Models\Aspirant;
use App\Models\Curador;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'document',
        'name',
        'last_name',
        'user_name',
        'email',
        'phone',
        'slug',
        'picture',
        'password',
        'birthday',
        'url_facebook',
        'url_youtube',
        'url_instagram',
        'url_tiktok',
        'url_snapchat',
        'url_spotify',
        'url_apple_music',
        'url_deezer',
        'web_site',
        'state',
        'address',
        'document_type_id',
        'gender_id',
        'city_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function aspirant(){
        return $this->hasOne(Aspirant::class, 'user_id');
    }

   static public function getCurador($id){
//        dd($id);
        $curador = Curador::where('user_id', $id)->first();
        return $curador;
    }
}
