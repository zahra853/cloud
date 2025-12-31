<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Booking;
use App\Models\Barang;
use App\Models\User;
use App\Models\VisitorAnalytic;
use App\Models\MembershipTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function dashboard()
    {
        // Get statistics
        $pendingOrders = Order::where('payment_status', 'pending')->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $totalProducts = Barang::count();
        $totalUsers = User::where('role', 'user')->count();
        $todayRevenue = Order::where('payment_status', 'paid')
            ->whereDate('created_at', today())
            ->sum('total');
        $totalOrders = Order::count();

        // Visitor Analytics
        $todayVisitors = VisitorAnalytic::uniqueVisitors('today');
        $weekVisitors = VisitorAnalytic::uniqueVisitors('week');
        $monthVisitors = VisitorAnalytic::uniqueVisitors('month');
        $todayPageViews = VisitorAnalytic::pageViews('today');
        $weekPageViews = VisitorAnalytic::pageViews('week');
        $monthPageViews = VisitorAnalytic::pageViews('month');

        // Membership Statistics
        $totalMembers = User::where('is_member', true)->count();
        $activeMembers = User::where('is_member', true)
            ->where(function($query) {
                $query->whereNull('membership_expires_at')
                      ->orWhere('membership_expires_at', '>', now());
            })->count();
        $membershipRevenue = MembershipTransaction::where('payment_status', 'paid')
            ->sum('amount');

        // Chart data for visitor analytics (last 7 days)
        $visitorChartData = [];
        $pageViewChartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $visitorChartData[] = [
                'date' => $date->format('M d'),
                'visitors' => VisitorAnalytic::whereDate('created_at', $date)
                    ->distinct('ip_address')->count()
            ];
            $pageViewChartData[] = [
                'date' => $date->format('M d'),
                'views' => VisitorAnalytic::whereDate('created_at', $date)->count()
            ];
        }

        // Top pages
        $topPages = VisitorAnalytic::selectRaw('page_title, COUNT(*) as views')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('page_title')
            ->orderByDesc('views')
            ->limit(5)
            ->get();

        // Device breakdown
        $deviceStats = VisitorAnalytic::selectRaw('device_type, COUNT(*) as count')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('device_type')
            ->get();

        // Recent orders (last 5)
        $recentOrders = Order::with(['user', 'orderItems'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Recent bookings (last 5)
        $recentBookings = Booking::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'pendingOrders',
            'pendingBookings',
            'totalProducts',
            'totalUsers',
            'todayRevenue',
            'totalOrders',
            'todayVisitors',
            'weekVisitors',
            'monthVisitors',
            'todayPageViews',
            'weekPageViews',
            'monthPageViews',
            'totalMembers',
            'activeMembers',
            'membershipRevenue',
            'visitorChartData',
            'pageViewChartData',
            'topPages',
            'deviceStats',
            'recentOrders',
            'recentBookings'
        ));
    }

    /**
     * Get analytics data for AJAX requests
     */
    public function getAnalyticsData(Request $request)
    {
        $period = $request->get('period', 7); // days
        
        $data = [];
        for ($i = $period - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $data[] = [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('M d'),
                'visitors' => VisitorAnalytic::whereDate('created_at', $date)
                    ->distinct('ip_address')->count(),
                'pageviews' => VisitorAnalytic::whereDate('created_at', $date)->count(),
            ];
        }
        
        return response()->json($data);
    }

    /**
     * Show users with subscription status
     */
    public function users()
    {
        $users = User::where('role', 'user')
            ->with('membershipTransactions')
            ->get()
            ->map(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'is_member' => $user->is_member,
                    'membership_type' => $user->membership_type,
                    'membership_expires_at' => $user->membership_expires_at,
                    'is_active_member' => $user->isActiveMember(),
                    'total_transactions' => $user->membershipTransactions->count(),
                    'total_spent' => $user->membershipTransactions
                        ->where('payment_status', 'paid')
                        ->sum('amount'),
                    'created_at' => $user->created_at,
                ];
            });

        return view('admin.users', compact('users'));
    }
}
