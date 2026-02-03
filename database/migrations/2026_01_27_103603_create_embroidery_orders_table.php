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
        Schema::create('embroidery_orders', function (Blueprint $table) {

            $table->id();
            $table->date('order_entry_date');
            $table->date('order_delivery_date');
            $table->string('emb_order_no')->unique();

            $table->unsignedBigInteger('artisan_group_id');

            $table->foreign('artisan_group_id')->references('id')->on('artisan_groups')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('production_challan_id');

            $table->foreign('production_challan_id')->references('id')->on('production_challans')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->string('name')->nullable();
            $table->text('description')->nullable();

            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total', 12, 2);

            $table->text('remark')->nullable();
            $table->tinyInteger('status')->comment('0=Pending, 1=Approved, 2=Recomended');
            
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')->cascadeOnUpdate()->restrictOnDelete();
            $table->timestamp('approved_at')->nullable();

            $table->unsignedBigInteger('user_id');
            
            $table->foreign('user_id')->references('id')->on('users')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->string('created_by',20)->nullable();
            $table->string('updated_by',20)->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('embroidery_orders');
    }
};
