<?php

namespace Database\Seeders;

use App\Models\MembershipTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MembershipTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();

        // Transaction 1: Paid membership (active) - VIP
        MembershipTransaction::create([
            'order_number' => 'MBR-' . strtoupper(uniqid()),
            'user_id' => $users->first()->id,
            'membership_type' => 'vip',
            'amount' => 500000,
            'duration_days' => 365,
            'payment_status' => 'paid',
            'midtrans_transaction_id' => 'TRX-MBR-' . strtoupper(uniqid()),
            'paid_at' => now()->subMonths(2),
            'expires_at' => now()->addMonths(10),
        ]);

        // Update user membership status
        $users->first()->update([
            'is_member' => true,
            'membership_expires_at' => now()->addMonths(10),
        ]);

        // Transaction 2: Paid membership (active) - Premium
        MembershipTransaction::create([
            'order_number' => 'MBR-' . strtoupper(uniqid()),
            'user_id' => $users->skip(1)->first()?->id ?? $users->first()->id,
            'membership_type' => 'premium',
            'amount' => 250000,
            'duration_days' => 180,
            'payment_status' => 'paid',
            'midtrans_transaction_id' => 'TRX-MBR-' . strtoupper(uniqid()),
            'paid_at' => now()->subMonth(),
            'expires_at' => now()->addMonths(5),
        ]);

        // Update user membership status
        if ($users->skip(1)->first()) {
            $users->skip(1)->first()->update([
                'is_member' => true,
                'membership_expires_at' => now()->addMonths(5),
            ]);
        }

        // Transaction 3: Pending payment - VIP
        MembershipTransaction::create([
            'order_number' => 'MBR-' . strtoupper(uniqid()),
            'user_id' => $users->skip(2)->first()?->id ?? $users->first()->id,
            'membership_type' => 'vip',
            'amount' => 500000,
            'duration_days' => 365,
            'payment_status' => 'pending',
            'midtrans_snap_token' => 'snap-token-' . uniqid(),
            'expires_at' => null,
        ]);

        // Transaction 4: Expired membership - Basic
        MembershipTransaction::create([
            'order_number' => 'MBR-' . strtoupper(uniqid()),
            'user_id' => $users->skip(3)->first()?->id ?? $users->first()->id,
            'membership_type' => 'basic',
            'amount' => 100000,
            'duration_days' => 90,
            'payment_status' => 'paid',
            'midtrans_transaction_id' => 'TRX-MBR-' . strtoupper(uniqid()),
            'paid_at' => now()->subMonths(8),
            'expires_at' => now()->subMonths(2),
        ]);

        // Transaction 5: Failed payment - Premium
        MembershipTransaction::create([
            'order_number' => 'MBR-' . strtoupper(uniqid()),
            'user_id' => $users->skip(4)->first()?->id ?? $users->first()->id,
            'membership_type' => 'premium',
            'amount' => 250000,
            'duration_days' => 180,
            'payment_status' => 'failed',
            'midtrans_response' => ['status_code' => '202', 'status_message' => 'Payment failed'],
            'expires_at' => null,
        ]);
    }
}
