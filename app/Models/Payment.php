<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = ['id','amount','currency','vendor_email'];
}
