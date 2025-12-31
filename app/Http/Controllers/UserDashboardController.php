<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Booking;
use App\Models\Barang;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Main dashboard
     */
    public function index()
    {
        $user = Auth::user();
        

        
        // Get user stats
        $totalOrders = $user->orders()->count();
        $totalBookings = $user->bookings()->count();
        $points = $user->points ?? 0;
        
        // Recent orders
        $recentOrders = $user->orders()
            ->with('orderItems.barang')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        // Upcoming bookings
        $upcomingBookings = $user->bookings()
            ->where('booking_date', '>=', now()->toDateString())
            ->where('status', '!=', 'cancelled')
            ->orderBy('booking_date')
            ->take(5)
            ->get();
        
        // Membership status - check user's membership fields directly
        $membership = (object) [
            'is_active' => $user->is_member && $user->membership_expires_at && $user->membership_expires_at->isFuture(),
            'type' => $user->membership_type,
            'expires_at' => $user->membership_expires_at,
        ];
        
        return view('user.dashboard.index', compact(
            'user', 'totalOrders', 'totalBookings', 'points',
            'recentOrders', 'upcomingBookings', 'membership'
        ));
    }

    /**
     * Orders history with menu
     */
    public function orders()
    {
        $orders = Auth::user()->orders()
            ->with('orderItems.barang')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Get available menus for ordering
        $menus = Barang::where('stock', '>', 0)->orderBy('name')->get();
        
        return view('user.dashboard.orders', compact('orders', 'menus'));
    }

    /**
     * Store new order from dashboard
     */
    public function storeOrder(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required|exists:barangs,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $user = Auth::user();

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = 0;
            $orderItems = [];

            foreach ($validated['items'] as $item) {
                $barang = Barang::find($item['id']);
                
                if ($barang->stock < $item['quantity']) {
                    return response()->json([
                        'success' => false,
                        'message' => "Stok {$barang->name} tidak mencukupi"
                    ], 400);
                }

                $itemTotal = $barang->price * $item['quantity'];
                $subtotal += $itemTotal;

                $orderItems[] = [
                    'barang_id' => $barang->id,
                    'quantity' => $item['quantity'],
                    'price' => $barang->price,
                    'subtotal' => $itemTotal,
                ];

                // Reduce stock
                $barang->decrement('stock', $item['quantity']);
            }

            // Apply member discount
            $discount = 0;
            if ($user->isActiveMember()) {
                $discountRates = ['basic' => 0.05, 'premium' => 0.10, 'vip' => 0.15];
                $rate = $discountRates[$user->membership_type] ?? 0;
                $discount = $subtotal * $rate;
            }

            $total = $subtotal - $discount;

            // Create order
            $orderNumber = 'ORD-' . strtoupper(uniqid());
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => $user->id,
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->phone,
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'tax' => 0,
                'total' => $total,
                'payment_status' => 'pending',
                'status' => 'pending',
                'order_type' => 'online',
            ]);

            // Create order items
            foreach ($orderItems as $item) {
                $order->orderItems()->create($item);
            }

            // Initialize Midtrans config
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production');
            \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
            \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

            // Create Midtrans payment
            $params = [
                'transaction_details' => [
                    'order_id' => $orderNumber,
                    'gross_amount' => (int) $total,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'email' => $user->email ?? 'customer@shop.test',
                    'phone' => $user->phone ?? '08123456789',
                ],
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $order->update(['midtrans_snap_token' => $snapToken]);

            DB::commit();

            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'order_number' => $orderNumber,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat pesanan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Bookings history
     */
    public function bookings()
    {
        $bookings = Auth::user()->bookings()
            ->orderBy('booking_date', 'desc')
            ->paginate(10);
        
        return view('user.dashboard.bookings', compact('bookings'));
    }

    /**
     * Store new booking from dashboard
     */
    public function storeBooking(Request $request)
    {
        $validated = $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required|string',
            'number_of_people' => 'required|integer|min:1|max:50',
            'table_number' => 'nullable|string',
            'notes' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        $booking = Booking::create([
            'user_id' => $user->id,
            'guest_name' => $user->name,
            'guest_email' => $user->email,
            'guest_phone' => $user->phone,
            'booking_date' => $validated['booking_date'],
            'booking_time' => $validated['booking_time'],
            'number_of_people' => $validated['number_of_people'],
            'table_number' => $validated['table_number'],
            'notes' => $validated['notes'],
            'status' => 'pending',
        ]);

        return redirect()->route('user.dashboard.bookings')
            ->with('success', 'Reservasi berhasil dibuat! Menunggu konfirmasi.');
    }

    /**
     * Cancel booking
     */
    public function cancelBooking($id)
    {
        $booking = Booking::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!in_array($booking->status, ['pending', 'confirmed'])) {
            return response()->json([
                'success' => false,
                'message' => 'Reservasi tidak dapat dibatalkan'
            ], 400);
        }

        $booking->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Reservasi berhasil dibatalkan'
        ]);
    }

    /**
     * Points & rewards
     */
    public function points()
    {
        $user = Auth::user();
        $points = $user->points ?? 0;
        
        return view('user.dashboard.points', compact('user', 'points'));
    }

    /**
     * Profile settings
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.dashboard.profile', compact('user'));
    }

    /**
     * Update profile
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);
        
        $user->update($validated);
        
        return back()->with('success', 'Profile berhasil diupdate!');
    }
}
