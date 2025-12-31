<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Handle Midtrans notification/callback
     */
    public function notification(Request $request)
    {
        try {
            // Log the incoming notification for debugging
            \Log::info('Midtrans Notification Received', [
                'content' => $request->getContent(),
                'headers' => $request->headers->all()
            ]);

            $notification = json_decode($request->getContent());
            
            if (!$notification) {
                throw new \Exception('Invalid JSON in notification');
            }

            $order = $this->midtransService->handleNotification($notification);

            \Log::info('Midtrans Notification Processed Successfully', [
                'order_id' => $order->order_number,
                'payment_status' => $order->payment_status
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notification handled successfully',
            ]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Notification Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Payment success page
     */
    public function success(Request $request)
    {
        $orderId = $request->query('order_id');
        return view('payment.success', compact('orderId'));
    }

    /**
     * Payment pending page
     */
    public function pending(Request $request)
    {
        $orderId = $request->query('order_id');
        return view('payment.pending', compact('orderId'));
    }

    /**
     * Payment failed page
     */
    public function failed(Request $request)
    {
        $orderId = $request->query('order_id');
        return view('payment.failed', compact('orderId'));
    }

    /**
     * Get webhook URL for Midtrans configuration
     */
    public function getWebhookUrl()
    {
        return view('payment.webhook-info');
    }
}