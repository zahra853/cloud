<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Change payment_method enum to include 'card'
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('midtrans', 'cash', 'transfer', 'card') NULL");
        
        // Add voucher columns if they don't exist
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'voucher_id')) {
                $table->foreignId('voucher_id')->nullable()->after('tax')->constrained()->nullOnDelete();
            }
            if (!Schema::hasColumn('orders', 'voucher_code')) {
                $table->string('voucher_code')->nullable()->after('voucher_id');
            }
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 12, 2)->default(0)->after('voucher_code');
            }
            if (!Schema::hasColumn('orders', 'customer_name')) {
                $table->string('customer_name')->nullable()->after('guest_phone');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method ENUM('midtrans', 'cash', 'transfer') NULL");
        
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['voucher_id']);
            $table->dropColumn(['voucher_id', 'voucher_code', 'discount_amount', 'customer_name']);
        });
    }
};
