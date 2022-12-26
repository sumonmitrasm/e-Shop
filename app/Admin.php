<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;
    protected $guard = 'admin';
    protected $fillable = [
    	'name','type','mobile','email','password','image','status','created_at','updated_at',
    ];
    protected $hidden = [
    	'password','remember_token',
    ];
}
