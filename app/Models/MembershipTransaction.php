<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MembershipTransaction extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'membership_type',
        'amount',
        'duration_days',
        'payment_status',
        'midtrans_transaction_id',
        'midtrans_snap_token',
        'midtrans_response',
        'paid_at',
        'expires_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'midtrans_response' => 'array',
        'paid_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Get the user that owns the transaction
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if transaction is paid
     */
    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Mark transaction as paid
     */
    public function markAsPaid($transactionId = null): void
    {
        $this->update([
            'payment_status' => 'paid',
            'paid_at' => now(),
            'midtrans_transaction_id' => $transactionId,
        ]);
    }
}
