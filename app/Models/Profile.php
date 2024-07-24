<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'occupation_id',
        'experience_year',
        'experience_month',
        'profile_description',
        'services',
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
        'profile_status',
        'expired_at'
    ];

    protected $with = ['vendor','occupation','profileImage'];

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
    public function favorite(){
        return $this->hasMany('App\Models\Favorite');
    }

    public function profileImage(){
        return $this->hasMany('App\Models\ProfileImage','vendor_id','vendor_id');
    }

    // protected function services(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn (string $value) => explode(',',$value),
    //     );
    // }

}
