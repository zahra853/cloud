<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use App\Models\Barang;
use App\Models\Voucher;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $barangs = Barang::all();
        $voucher = Voucher::where('code', 'MEMBER10')->first();

        // Order 1: Completed order with user (paid)
        $order1 = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => $users->first()->id,
            'voucher_id' => $voucher?->id,
            'voucher_code' => $voucher?->code,
            'discount_amount' => 5000,
            'subtotal' => 75000,
            'tax' => 7000,
            'total' => 77000,
            'payment_status' => 'paid',
            'payment_method' => 'midtrans',
            'midtrans_transaction_id' => 'TRX-' . strtoupper(uniqid()),
            'status' => 'completed',
            'order_type' => 'dine_in',
            'notes' => 'Tidak pakai sambal',
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'barang_id' => $barangs->where('name', 'Nasi Goreng Special')->first()?->id ?? $barangs->first()->id,
            'quantity' => 2,
            'price' => 35000,
            'subtotal' => 70000,
        ]);

        OrderItem::create([
            'order_id' => $order1->id,
            'barang_id' => $barangs->where('name', 'Es Teh Manis')->first()?->id ?? $barangs->first()->id,
            'quantity' => 2,
            'price' => 8000,
            'subtotal' => 16000,
        ]);

        // Order 2: Pending order
        $order2 = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => $users->skip(1)->first()?->id ?? $users->first()->id,
            'subtotal' => 95000,
            'tax' => 9500,
            'total' => 104500,
            'payment_status' => 'pending',
            'status' => 'pending',
            'order_type' => 'takeaway',
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'barang_id' => $barangs->where('name', 'Ayam Bakar Madu')->first()?->id ?? $barangs->first()->id,
            'quantity' => 1,
            'price' => 45000,
            'subtotal' => 45000,
        ]);

        OrderItem::create([
            'order_id' => $order2->id,
            'barang_id' => $barangs->where('name', 'Mie Goreng Seafood')->first()?->id ?? $barangs->first()->id,
            'quantity' => 1,
            'price' => 40000,
            'subtotal' => 40000,
        ]);

        // Order 3: Guest order (paid)
        $order3 = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => null,
            'guest_name' => 'Andi Wijaya',
            'guest_email' => 'andi@example.com',
            'guest_phone' => '081234567891',
            'subtotal' => 60000,
            'tax' => 6000,
            'total' => 66000,
            'payment_status' => 'paid',
            'payment_method' => 'cash',
            'status' => 'completed',
            'order_type' => 'dine_in',
        ]);

        OrderItem::create([
            'order_id' => $order3->id,
            'barang_id' => $barangs->where('name', 'Sate Ayam')->first()?->id ?? $barangs->first()->id,
            'quantity' => 2,
            'price' => 30000,
            'subtotal' => 60000,
        ]);

        // Order 4: Processing order
        $order4 = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => $users->skip(2)->first()?->id ?? $users->first()->id,
            'subtotal' => 120000,
            'tax' => 12000,
            'total' => 132000,
            'payment_status' => 'paid',
            'payment_method' => 'midtrans',
            'midtrans_transaction_id' => 'TRX-' . strtoupper(uniqid()),
            'status' => 'processing',
            'order_type' => 'dine_in',
            'notes' => 'Meja nomor 5',
        ]);

        OrderItem::create([
            'order_id' => $order4->id,
            'barang_id' => $barangs->where('name', 'Sop Buntut')->first()?->id ?? $barangs->first()->id,
            'quantity' => 2,
            'price' => 55000,
            'subtotal' => 110000,
        ]);

        // Order 5: Cancelled order
        $order5 = Order::create([
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'user_id' => null,
            'guest_name' => 'Dewi Lestari',
            'guest_email' => 'dewi@example.com',
            'guest_phone' => '085678901235',
            'subtotal' => 50000,
            'tax' => 5000,
            'total' => 55000,
            'payment_status' => 'failed',
            'status' => 'cancelled',
            'order_type' => 'takeaway',
            'notes' => 'Pembayaran gagal',
        ]);

        OrderItem::create([
            'order_id' => $order5->id,
            'barang_id' => $barangs->where('name', 'Gado-Gado')->first()?->id ?? $barangs->first()->id,
            'quantity' => 2,
            'price' => 25000,
            'subtotal' => 50000,
        ]);
    }
}
