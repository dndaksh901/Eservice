<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'occupation_id',
        'experience_year',
        'experience_month',
        'profile_description',
        'rating',
        'ranking_id',
        'price_per_hour',
        'address',
        'country_id',
        'state_id',
        'city_id',
        'latitude',
        'longitude',
        'pincode',
        'profile_status'
    ];

    protected $with = ['vendor','occupation','state','country','city'];

    public function vendor(){
        return $this->belongsTo('App\Models\Vendor');
    }

    public function occupation(){
        return $this->belongsTo('App\Models\Occupation');
    }

    public function country(){
        return $this->belongsTo('App\Models\Country');
    }

    public function state(){
        return $this->belongsTo('App\Models\State');
    }

    public function city(){
        return $this->belongsTo('App\Models\City');
    }

}
