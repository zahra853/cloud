<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'guest_name',
        'guest_email',
        'guest_phone',
        'customer_name',
        'customer_email',
        'customer_phone',
        'voucher_id',
        'voucher_code',
        'discount_amount',
        'subtotal',
        'tax',
        'total',
        'payment_status',
        'payment_method',
        'midtrans_transaction_id',
        'midtrans_snap_token',
        'status',
        'order_type',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            if (empty($order->order_number)) {
                $order->order_number = 'ORD-' . strtoupper(uniqid());
            }
        });
    }

    /**
     * Get the user who made the order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the voucher used in this order
     */
    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
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
     * Check if order is paid
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }
}
