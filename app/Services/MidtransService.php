<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use App\Models\Order;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Create Snap token for payment
     */
    public function createSnapToken(Order $order, $customCustomerDetails = null)
    {
        // Use custom customer details if provided, otherwise use order data
        if ($customCustomerDetails) {
            $customerDetails = [
                'first_name' => $customCustomerDetails['first_name'] ?? 'Customer',
                'email' => $customCustomerDetails['email'] ?? 'customer@shop.test',
                'phone' => $customCustomerDetails['phone'] ?? '08123456789',
            ];
        } else {
            // Ensure valid email - Midtrans requires valid email format
            $email = $order->customer_email ?? $order->guest_email ?? 'customer@shop.test';
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $email = 'customer@shop.test';
            }

            $customerDetails = [
                'first_name' => $order->customer_name ?? $order->guest_name ?? 'Customer',
                'email' => $email,
                'phone' => $order->customer_phone ?? $order->guest_phone ?? '08123456789',
            ];
        }

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => $customerDetails,
            'item_details' => $this->getItemDetails($order),
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            throw new \Exception('Failed to create Snap token: ' . $e->getMessage());
        }
    }

    /**
     * Get item details for Midtrans
     */
    private function getItemDetails(Order $order)
    {
        $items = [];
        
        foreach ($order->orderItems as $item) {
            $items[] = [
                'id' => $item->barang_id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => $item->barang->name,
            ];
        }

        // Add tax if exists
        if ($order->tax > 0) {
            $items[] = [
                'id' => 'TAX',
                'price' => (int) $order->tax,
                'quantity' => 1,
                'name' => 'Tax',
            ];
        }

        return $items;
    }

    /**
     * Handle notification from Midtrans
     */
    public function handleNotification($notification)
    {
        try {
            // Get transaction ID from notification
            $transactionId = $notification->transaction_id ?? null;
            $orderId = $notification->order_id ?? null;

            if (!$transactionId && !$orderId) {
                throw new \Exception('Missing transaction_id or order_id in notification');
            }

            // Get transaction status from Midtrans
            $transaction = Transaction::status($transactionId);
            
            $orderNumber = $transaction->order_id;
            $order = Order::where('order_number', $orderNumber)->first();

            if (!$order) {
                throw new \Exception('Order not found: ' . $orderNumber);
            }

            // Log the transaction status for debugging
            \Log::info('Processing Midtrans Transaction', [
                'order_number' => $orderNumber,
                'transaction_id' => $transaction->transaction_id,
                'transaction_status' => $transaction->transaction_status,
                'fraud_status' => $transaction->fraud_status ?? 'N/A'
            ]);

            // Update order based on transaction status
            $order->midtrans_transaction_id = $transaction->transaction_id;

            if ($transaction->transaction_status == 'capture') {
                if ($transaction->fraud_status == 'accept') {
                    $order->payment_status = 'paid';
                    $order->status = 'processing';
                }
            } else if ($transaction->transaction_status == 'settlement') {
                $order->payment_status = 'paid';
                $order->status = 'processing';
            } else if ($transaction->transaction_status == 'pending') {
                $order->payment_status = 'pending';
            } else if ($transaction->transaction_status == 'deny' || 
                       $transaction->transaction_status == 'expire' || 
                       $transaction->transaction_status == 'cancel') {
                $order->payment_status = 'failed';
                $order->status = 'cancelled';
            }

            $order->save();

            return $order;
        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Processing Error', [
                'error' => $e->getMessage(),
                'notification' => $notification
            ]);
            throw new \Exception('Failed to handle notification: ' . $e->getMessage());
        }
    }

    /**
     * Check transaction status
     */
    public function checkTransactionStatus($orderId)
    {
        try {
            return Transaction::status($orderId);
        } catch (\Exception $e) {
            throw new \Exception('Failed to check transaction status: ' . $e->getMessage());
        }
    }
}
