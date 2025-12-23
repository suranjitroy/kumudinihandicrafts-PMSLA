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
        Schema::table('production_work_orders', function (Blueprint $table) {
            
            $table->date('order_delivery_date')->nullable()->after('order_entry_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('production_work_orders', function (Blueprint $table) {
            $table->dropColumn('order_delivery_date');
        });
    }
};
