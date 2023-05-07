<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable=['name','currency','iso3','status'];

    public function country(){
        return $this->belongsTo('App\Models\Country');
    }
}
