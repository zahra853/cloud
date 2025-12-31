<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\MidtransService;
use App\Models\Order;

class TestMidtransWebhook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'midtrans:test-webhook {order_number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Midtrans webhook with a specific order';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $orderNumber = $this->argument('order_number');
        
        $order = Order::where('order_number', $orderNumber)->first();
        
        if (!$order) {
            $this->error("Order not found: {$orderNumber}");
            return 1;
        }

        $this->info("Testing webhook for order: {$orderNumber}");
        $this->info("Current payment status: {$order->payment_status}");
        
        if (!$order->midtrans_transaction_id) {
            $this->error("Order doesn't have Midtrans transaction ID");
            return 1;
        }

        try {
            $midtransService = new MidtransService();
            $status = $midtransService->checkTransactionStatus($order->midtrans_transaction_id);
            
            $this->info("Transaction Status from Midtrans:");
            $this->line("- Transaction ID: {$status->transaction_id}");
            $this->line("- Status: {$status->transaction_status}");
            $this->line("- Fraud Status: " . ($status->fraud_status ?? 'N/A'));
            
            // Simulate notification
            $notification = (object) [
                'transaction_id' => $status->transaction_id,
                'order_id' => $status->order_id,
                'transaction_status' => $status->transaction_status,
                'fraud_status' => $status->fraud_status ?? null
            ];
            
            $updatedOrder = $midtransService->handleNotification($notification);
            
            $this->info("Order updated successfully!");
            $this->line("- New payment status: {$updatedOrder->payment_status}");
            $this->line("- New order status: {$updatedOrder->status}");
            
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }
}
