<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
        'is_member',
        'membership_type',
        'membership_expires_at',
        'phone',
        'address',
        'google_id',
        'avatar',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_member' => 'boolean',
            'membership_expires_at' => 'datetime',
        ];
    }

    /**
     * Get the bookings for this user
     */
    public function bookings()
    {
        return $this->hasMany(\App\Models\Booking::class);
    }

    /**
     * Get the orders for this user
     */
    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class);
    }

    /**
     * Check if user is an active member
     */
    public function isActiveMember(): bool
    {
        if (!$this->is_member) {
            return false;
        }

        if ($this->membership_expires_at && $this->membership_expires_at->isPast()) {
            return false;
        }

        return true;
    }

    /**
     * Activate membership for specified duration (in days)
     */
    public function activateMembership(int $days = 365, string $type = 'basic'): void
    {
        $this->is_member = true;
        $this->membership_type = $type;
        $this->membership_expires_at = now()->addDays($days);
        $this->save();
    }

    /**
     * Get the membership transactions for this user
     */
    public function membershipTransactions()
    {
        return $this->hasMany(\App\Models\MembershipTransaction::class);
    }

    /**
     * Get the latest membership transaction
     */
    public function latestMembershipTransaction()
    {
        return $this->hasOne(\App\Models\MembershipTransaction::class)->latest();
    }
}