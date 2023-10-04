<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'vendor_id',
        'user_id',
        'rating',
        'review',
        'status'
    ];

    public function vendor()
    {
        return $this->belongsTo('App\Models\Vendor');
    }
    public function profile()
    {
        return $this->belongsTo('App\Models\Profile')->select('id','rating');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
