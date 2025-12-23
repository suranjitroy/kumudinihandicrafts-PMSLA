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
        Schema::create('order_distribution_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('production_work_order_id');

            $table->foreign('production_work_order_id')->references('id')->on('production_work_orders')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->string('production_order_no');

            $table->unsignedBigInteger('order_distribution_id');

            $table->foreign('order_distribution_id')->references('id')->on('order_distributions')
            ->cascadeOnUpdate()->restrictOnDelete();
            
            $table->unsignedBigInteger('worker_info_id');

            $table->foreign('worker_info_id')->references('id')->on('worker_infos')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('bahar_id');

            $table->foreign('bahar_id')->references('id')->on('bahars')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('size_id');

            $table->foreign('size_id')->references('id')->on('sizes')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->decimal('order_quantity', 8, 2);

            $table->date('assing_entry_date');

            $table->date('assing_delivery_date');

            $table->integer('assing_quantity');
            
            $table->longText('remarks');

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
        Schema::dropIfExists('order_distribution_items');
    }
};
