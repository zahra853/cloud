<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('visitor_analytics', function (Blueprint $table) {
            // Drop index first
            $table->dropIndex(['created_at', 'page_url']);
        });
        
        Schema::table('visitor_analytics', function (Blueprint $table) {
            // Change column types
            $table->text('page_url')->change();
            $table->text('user_agent')->nullable()->change();
            
            // Re-add index without page_url
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('visitor_analytics', function (Blueprint $table) {
            $table->string('page_url')->change();
            $table->string('user_agent')->nullable()->change();
        });
    }
};