<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use HasFactory;

    protected $table = "favorite";

    protected $fillable =['profile_id','vendor_id','user_id'];

    public function profile(){
        return $this->belongsTo('App\Models\Profile');
    }
}
