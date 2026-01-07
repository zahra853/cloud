<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // For SQLite, we need to recreate the table or use a different approach
        // Instead of modifying ENUM, we'll just add the new columns
        // The payment_method validation can be handled at application level

        Schema::table('orders', function (Blueprint $table) {
            // Add voucher columns if they don't exist
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

        // Note: payment_method can already accept 'card' as it's stored as string in SQLite
        // ENUM constraints are only enforced at MySQL level
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'voucher_id')) {
                $table->dropForeign(['voucher_id']);
            }
            $table->dropColumn(['voucher_id', 'voucher_code', 'discount_amount', 'customer_name']);
        });
    }
};
