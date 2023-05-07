<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EnquiryUser extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = "enquiry_users";
    protected $fillable =['vendor_id','user_id','client_name','client_address','client_phone','client_email','client_budget','client_note','client_status_id'];

    public function vendor(){
        return $this->belongsTo('App\Models\Vendor');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function clientStatus(){
        return $this->belongsTo('App\Models\ClientStatus','client_status_id','id');
    }
}
