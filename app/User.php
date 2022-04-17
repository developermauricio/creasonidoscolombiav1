<?php

namespace App;

use App\Models\Aspirant;
use App\Models\City;
use App\Models\Curador;
use App\Models\Gender;
use App\Notifications\CustomResetPasswordNotification;
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

    public function sendPasswordResetNotification($token){
        $this->notify(new CustomResetPasswordNotification($token));
    }

    public function aspirant(){
        return $this->hasOne(Aspirant::class, 'user_id');
    }

    public function gender(){
        return $this->belongsTo(Gender::class, 'gender_id');
    }

    public function city(){
        return $this->belongsTo(City::class, 'city_id');
    }

    public static function navigation(){

        return auth()->check() ? auth()->user()->roles[0]->name : 'Aspirante';
    }

   static public function getCurador($id){
//        dd($id);
        $curador = Curador::where('user_id', $id)->first();
        return $curador;
    }
}
