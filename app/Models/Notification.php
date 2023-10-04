<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;
    protected $table ="notification";
    public $fillable = ['name', 'phone', 'message','budget', 'user_id', 'vendor_id', 'is_read'];

    protected $dates = ['deleted_at'];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function vendor(){
        return $this->belongsTo('App\Models\Vendor');
    }
}
