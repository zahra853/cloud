<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Voucher::create([
            'code' => 'MEMBER10',
            'name' => 'Member Discount 10%',
            'description' => 'Diskon 10% untuk member aktif',
            'discount_type' => 'percentage',
            'discount_value' => 10,
            'min_purchase' => 50000,
            'max_discount' => 50000,
            'usage_limit' => null,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(6),
            'member_only' => true,
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'MEMBER20',
            'name' => 'Member Discount 20%',
            'description' => 'Diskon 20% untuk member dengan minimum pembelian Rp 100.000',
            'discount_type' => 'percentage',
            'discount_value' => 20,
            'min_purchase' => 100000,
            'max_discount' => 100000,
            'usage_limit' => 100,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(3),
            'member_only' => true,
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'WELCOME50',
            'name' => 'Welcome Bonus Rp 50.000',
            'description' => 'Diskon Rp 50.000 untuk pelanggan baru',
            'discount_type' => 'fixed',
            'discount_value' => 50000,
            'min_purchase' => 150000,
            'max_discount' => null,
            'usage_limit' => 50,
            'valid_from' => now(),
            'valid_until' => now()->addMonth(),
            'member_only' => false,
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'DISC5',
            'name' => 'Diskon 5%',
            'description' => 'Diskon 5% tanpa minimum pembelian',
            'discount_type' => 'percentage',
            'discount_value' => 5,
            'min_purchase' => 0,
            'max_discount' => 25000,
            'usage_limit' => 200,
            'valid_from' => now(),
            'valid_until' => now()->addMonths(2),
            'member_only' => false,
            'is_active' => true,
        ]);

        Voucher::create([
            'code' => 'WEEKEND15',
            'name' => 'Weekend Special 15%',
            'description' => 'Diskon 15% untuk akhir pekan',
            'discount_type' => 'percentage',
            'discount_value' => 15,
            'min_purchase' => 75000,
            'max_discount' => 75000,
            'usage_limit' => 100,
            'valid_from' => now(),
            'valid_until' => now()->addWeeks(4),
            'member_only' => false,
            'is_active' => true,
        ]);
    }
}
