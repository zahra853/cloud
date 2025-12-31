<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'booking_date',
        'booking_time',
        'number_of_people',
        'special_request',
        'status',
        'table_number',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'booking_time' => 'datetime',
    ];

    /**
     * Get the user who made the booking
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the customer name (from user or guest)
     */
    public function getCustomerNameAttribute(): string
    {
        return $this->user ? $this->user->name : ($this->guest_name ?? 'Guest');
    }

    /**
     * Get the customer email (from user or guest)
     */
    public function getCustomerEmailAttribute(): string
    {
        return $this->user ? $this->user->email : ($this->guest_email ?? '');
    }

    /**
     * Get the customer phone (from guest data)
     */
    public function getCustomerPhoneAttribute(): string
    {
        return $this->guest_phone ?? '';
    }
}
