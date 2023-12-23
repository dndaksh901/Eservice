<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Vendor extends Authenticatable

{
    use HasFactory;
    use Notifiable;

    protected $guard="vendor";
    protected $table = "vendors";

    protected $fillable = [
        'username','name','address','avatar','city','state','country','pincode','email','password','mobile','dob','gender','image','status','remember_token','email_verified_at','remember_token','status'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profileImage(){
        return $this->hasMany('App\Models\ProfileImage');
    }
    public function profile(){
        return $this->hasOne('App\Models\Profile');
    }
}
