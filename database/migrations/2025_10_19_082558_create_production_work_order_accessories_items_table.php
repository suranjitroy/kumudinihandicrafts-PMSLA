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
        Schema::create('production_work_order_accessories_items', function (Blueprint $table) {
            
            $table->id();

            $table->unsignedBigInteger('production_work_order_id');

            $table->foreign('production_work_order_id','pwo_acc_items_pwo_fk')->references('id')->on('production_work_orders')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->string('production_order_no', 50);

            $table->unsignedBigInteger('item_id');

            $table->foreign('item_id')->references('id')->on('items')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('material_setup_id');

            $table->foreign('material_setup_id','material_setup_acc_fk')->references('id')->on('material_setups')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('size_id');

            $table->foreign('size_id')->references('id')->on('sizes')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->decimal('order_quantity', 8, 2);

            $table->unsignedBigInteger('unit_id');

            $table->foreign('unit_id')->references('id')->on('units')
            ->cascadeOnUpdate()->restrictOnDelete();
            
            $table->tinyInteger('status')->comment('0=Pending, 1=Approved, 2=Recomended');

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
        Schema::dropIfExists('production_work_order_accessories_items');
    }
};
