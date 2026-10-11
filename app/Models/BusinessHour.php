<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'weekly_hours',
        'special_dates',
        'slot_duration',
    ];

    protected $casts = [
        'weekly_hours' => 'array',
        'special_dates' => 'array',
        'slot_duration' => 'integer',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
