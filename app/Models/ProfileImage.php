<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_image',
        'vendor_id',
        'status'
    ];

    public function vendor(){
        return $this->belongsTo('App\Models\Vendor');
    }


}
