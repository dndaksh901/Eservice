<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Model
{
    use HasFactory;
    use Notifiable;

        protected $guard = 'admin';

        protected $fillable = [
            'name', 'email', 'password', 'role'
        ];

        protected $hidden = [
            'password', 'remember_token',
        ];
}
