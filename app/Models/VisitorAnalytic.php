<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VisitorAnalytic extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'page_url',
        'page_title',
        'referrer',
        'device_type',
        'browser',
        'os',
        'country',
        'city',
        'session_duration',
        'user_id',
    ];

    /**
     * Get the user that owns the visitor analytic
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get visitor analytics for today
     */
    public static function today()
    {
        return static::whereDate('created_at', today());
    }

    /**
     * Get visitor analytics for this week
     */
    public static function thisWeek()
    {
        return static::whereBetween('created_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ]);
    }

    /**
     * Get visitor analytics for this month
     */
    public static function thisMonth()
    {
        return static::whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year);
    }

    /**
     * Get unique visitors count
     */
    public static function uniqueVisitors($period = 'today')
    {
        $query = static::query();
        
        switch ($period) {
            case 'week':
                $query = static::thisWeek();
                break;
            case 'month':
                $query = static::thisMonth();
                break;
            default:
                $query = static::today();
        }
        
        return $query->distinct('ip_address')->count();
    }

    /**
     * Get page views count
     */
    public static function pageViews($period = 'today')
    {
        switch ($period) {
            case 'week':
                return static::thisWeek()->count();
            case 'month':
                return static::thisMonth()->count();
            default:
                return static::today()->count();
        }
    }
}
