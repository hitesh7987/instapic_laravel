<?php

namespace App;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function user_profile(){
        return $this->hasOne("App\Models\UserProfile");
    }
    
    public function photos(){
        return $this->hasMany("App\Models\Photo");
    }   

    public function posts(){
        return $this->hasMany("App\Post");
    }   

    public function AuthAccessToken(){
        return $this->hasMany("App\OauthAccessToken");
    }
}
