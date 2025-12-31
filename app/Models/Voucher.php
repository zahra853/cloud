<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'min_purchase',
        'max_discount',
        'usage_limit',
        'used_count',
        'valid_from',
        'valid_until',
        'member_only',
        'is_active',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'valid_from' => 'datetime',
        'valid_until' => 'datetime',
        'member_only' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Check if voucher is valid for use
     */
    public function isValid(User $user = null, float $orderTotal = 0): array
    {
        // Check if active
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Voucher tidak aktif'];
        }

        // Check if within validity period
        $now = now();
        if ($this->valid_from && $now->isBefore($this->valid_from)) {
            return ['valid' => false, 'message' => 'Voucher belum berlaku'];
        }

        if ($this->valid_until && $now->isAfter($this->valid_until)) {
            return ['valid' => false, 'message' => 'Voucher sudah expired'];
        }

        // Check usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'Voucher sudah habis digunakan'];
        }

        // Check minimum purchase
        if ($orderTotal < $this->min_purchase) {
            return ['valid' => false, 'message' => 'Minimum pembelian Rp ' . number_format($this->min_purchase, 0, ',', '.')];
        }

        // Check member only
        if ($this->member_only) {
            if (!$user || !$user->isActiveMember()) {
                return ['valid' => false, 'message' => 'Voucher hanya untuk member'];
            }
        }

        return ['valid' => true, 'message' => 'Voucher valid'];
    }

    /**
     * Calculate discount amount
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($this->discount_type === 'percentage') {
            $discount = $subtotal * ($this->discount_value / 100);
            
            // Apply max discount if set
            if ($this->max_discount && $discount > $this->max_discount) {
                return $this->max_discount;
            }
            
            return $discount;
        }

        // Fixed discount
        return min($this->discount_value, $subtotal);
    }

    /**
     * Increment usage count
     */
    public function incrementUsage(): void
    {
        $this->increment('used_count');
    }

    /**
     * Get orders that used this voucher
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
