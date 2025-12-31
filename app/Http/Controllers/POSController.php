<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Voucher;
use App\Services\MidtransService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class POSController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Display POS interface
     */
    public function index()
    {
        $products = Barang::where('is_available', true)
            ->where('stock', '>', 0)
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        $categories = Barang::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->orderBy('category')
            ->pluck('category');

        $clientKey = config('midtrans.client_key');

        return view('admin.pos.index', compact('products', 'categories', 'clientKey'));
    }

    /**
     * Create POS transaction
     */
    public function createTransaction(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.barang_id' => 'required|exists:barangs,id',
            'items.*.quantity' => 'required|integer|min:1',
            'customer_name' => 'nullable|string|max:255',
            'payment_method' => 'required|in:cash,card,midtrans',
            'voucher_code' => 'nullable|string',
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

            // Apply voucher if provided
            $discount = 0;
            $voucherId = null;
            $voucherCode = null;

            if (!empty($validated['voucher_code'])) {
                $voucher = Voucher::where('code', strtoupper($validated['voucher_code']))
                    ->where('is_active', true)
                    ->first();

                if ($voucher) {
                    $validation = $voucher->isValid(null, $subtotal);
                    if ($validation['valid']) {
                        $discount = $voucher->calculateDiscount($subtotal);
                        $voucherId = $voucher->id;
                        $voucherCode = $voucher->code;
                        $voucher->incrementUsage();
                    }
                }
            }

            $tax = 0; // No tax
            $total = $subtotal - $discount;

            // Create order
            $orderData = [
                'subtotal' => $subtotal,
                'voucher_id' => $voucherId,
                'voucher_code' => $voucherCode,
                'discount_amount' => $discount,
                'tax' => $tax,
                'total' => $total,
                'payment_status' => $validated['payment_method'] === 'cash' || $validated['payment_method'] === 'card' ? 'paid' : 'pending',
                'payment_method' => $validated['payment_method'],
                'status' => 'completed',
            ];

            // Set guest name if provided
            if (!empty($validated['customer_name'])) {
                $orderData['guest_name'] = $validated['customer_name'];
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

            DB::commit();

            // If Midtrans, generate Snap token
            $snapToken = null;
            if ($validated['payment_method'] === 'midtrans') {
                try {
                    $order->load('orderItems.barang');
                    
                    // Prepare customer details for Midtrans
                    $customerDetails = [
                        'first_name' => $validated['customer_name'] ?? 'POS Customer',
                        'email' => 'customer@example.com', // Dummy email if not provided
                        'phone' => '08123456789', // Dummy phone if not provided
                    ];
                    
                    $snapToken = $this->midtransService->createSnapToken($order, $customerDetails);
                    
                    // Save snap token to order
                    $order->update(['midtrans_snap_token' => $snapToken]);
                } catch (\Exception $e) {
                    // If Midtrans fails, still return success but without token
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal membuat Snap token: ' . $e->getMessage(),
                    ], 400);
                }
            }

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'total' => $total,
                'message' => 'Transaksi berhasil!',
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
     * Get POS receipt
     */
    public function receipt($orderId)
    {
        $order = Order::with('orderItems.barang', 'voucher')->findOrFail($orderId);
        return view('admin.pos.receipt', compact('order'));
    }

    /**
     * Get transactions history
     */
    public function transactions()
    {
        $orders = Order::with('orderItems')
            ->whereIn('payment_method', ['cash', 'card'])
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.pos.transactions', compact('orders'));
    }
}
