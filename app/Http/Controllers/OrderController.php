<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Barang;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Display user's orders
     */
    public function index()
    {
        $orders = Auth::user()->orders()
            ->with('orderItems.barang')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('user.orders.index', compact('orders'));
    }

    /**
     * Checkout from cart
     */
    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return back()->with('error', 'Cart is empty!');
        }
        
        DB::beginTransaction();
        try {
            $subtotal = 0;
            $items = [];
            
            foreach ($cart as $id => $item) {
                $barang = Barang::findOrFail($id);
                
                // Check stock
                if ($barang->stok < $item['qty']) {
                    throw new \Exception("Stock tidak cukup untuk {$barang->nama}");
                }
                
                $itemSubtotal = $item['price'] * $item['qty'];
                $subtotal += $itemSubtotal;
                
                $items[] = [
                    'barang' => $barang,
                    'qty' => $item['qty'],
                    'price' => $item['price'],
                    'subtotal' => $itemSubtotal,
                ];
            }
            
            // Apply voucher discount
            $discountAmount = session('discount', 0);
            $voucherCode = session('voucher_code');
            $total = $subtotal - $discountAmount;
            
            // Create order
            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper(uniqid()),
                'user_id' => Auth::id(),
                'customer_name' => Auth::user()->name,
                'subtotal' => $subtotal,
                'discount_amount' => $discountAmount,
                'voucher_code' => $voucherCode,
                'total' => $total,
                'payment_status' => 'pending',
                'payment_method' => 'midtrans',
                'status' => 'pending',
            ]);
            
            // Create order items and reduce stock
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'barang_id' => $item['barang']->id,
                    'jumlah' => $item['qty'],
                    'harga' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);
                
                // Reduce stock
                $item['barang']->decrement('stok', $item['qty']);
            }
            
            // Clear cart
            session()->forget(['cart', 'voucher_code', 'discount']);
            
            DB::commit();
            
            return redirect()->route('user.orders')
                ->with('success', 'Order placed successfully! Order #' . $order->order_number);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Create a new order from cart
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.quantity' => 'required|integer|min:1',
            'guest_name' => 'required_without:user_id|string|max:255',
            'guest_email' => 'required_without:user_id|email',
            'guest_phone' => 'required_without:user_id|string|max:20',
            'notes' => 'nullable|string|max:500',
        ]);

        DB::beginTransaction();
        try {
            // Calculate totals
            $subtotal = 0;
            $items = [];

            foreach ($validated['items'] as $item) {
                $barang = Barang::findOrFail($item['barang_id']);
                
                // Check stock
                if ($barang->stock < $item['quantity']) {
                    throw new \Exception("Stock tidak cukup untuk {$barang->name}");
                }

                $price = $barang->final_price;
                $itemSubtotal = $price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $items[] = [
                    'barang' => $barang,
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'subtotal' => $itemSubtotal,
                ];
            }

            $tax = $subtotal * 0.1; // 10% tax
            $total = $subtotal + $tax;

            // Create order
            $orderData = [
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'payment_status' => 'pending',
                'payment_method' => 'midtrans',
                'status' => 'pending',
                'notes' => $validated['notes'] ?? null,
            ];

            if (Auth::check() && Auth::user()->role !== 'guest') {
                $orderData['user_id'] = Auth::id();
            } else {
                $orderData['guest_name'] = $validated['guest_name'];
                $orderData['guest_email'] = $validated['guest_email'];
                $orderData['guest_phone'] = $validated['guest_phone'];
            }

            $order = Order::create($orderData);

            // Create order items and reduce stock
            foreach ($items as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'barang_id' => $item['barang']->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Reduce stock
                $item['barang']->decrement('stock', $item['quantity']);
            }

            // Create Midtrans Snap Token
            $snapToken = $this->midtransService->createSnapToken($order);
            $order->midtrans_snap_token = $snapToken;
            $order->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'snap_token' => $snapToken,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        // Check authorization
        if (Auth::check() && $order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('orderItems.barang');
        return view('user.orders.show', compact('order'));
    }

    // ===== ADMIN METHODS =====

    /**
     * Admin: List all orders
     */
    public function adminIndex()
    {
        $orders = Order::with(['user', 'orderItems'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Admin: Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $order->update($validated);

        return back()->with('success', 'Status order berhasil diupdate!');
    }

    /**
     * Admin: View order details
     */
    public function adminShow(Order $order)
    {
        $order->load('orderItems.barang', 'user');
        return view('admin.orders.show', compact('order'));
    }
}
