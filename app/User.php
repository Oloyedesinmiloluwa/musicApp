<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\CamelCase;

class User extends Authenticatable
{
    use Notifiable;
    // use CamelCase;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'firstName', 'lastName', 'email', 'password', 'bio', 'photo'
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

    public function favouriteTracks()
    {
        // return $this->hasMany('App\Favourite', 'userId', 'id');
        return $this->hasManyThrough('App\Track', 'App\Favourite', 'userId', 'id', 'id', 'trackId');
    }
}
