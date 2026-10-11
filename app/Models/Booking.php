<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_reference',
        'vendor_id',
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'service_title',
        'booking_date',
        'booking_time_slot',
        'booking_address',
        'notes',
        'price',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'price' => 'decimal:2',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get HTML status badge
     */
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'confirmed' => '<span class="badge bg-primary-subtle text-primary border border-primary px-3 py-1 rounded-pill"><i class="fas fa-check-circle me-1"></i> Confirmed</span>',
            'completed' => '<span class="badge bg-success-subtle text-success border border-success px-3 py-1 rounded-pill"><i class="fas fa-check-double me-1"></i> Completed</span>',
            'cancelled' => '<span class="badge bg-danger-subtle text-danger border border-danger px-3 py-1 rounded-pill"><i class="fas fa-times-circle me-1"></i> Cancelled</span>',
            default     => '<span class="badge bg-warning-subtle text-warning border border-warning px-3 py-1 rounded-pill"><i class="fas fa-clock me-1"></i> Pending</span>',
        };
    }
}
