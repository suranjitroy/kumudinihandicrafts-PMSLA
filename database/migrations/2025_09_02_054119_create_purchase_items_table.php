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
        Schema::create('purchase_items', function (Blueprint $table) {

            $table->id();
            $table->date('entry_date');
            $table->string('purchase_no', 50);

            $table->unsignedBigInteger('purchase_id');

            $table->foreign('purchase_id')->references('id')->on('purchases')
            ->cascadeOnUpdate()->restrictOnDelete();

    
             $table->unsignedBigInteger('store_id');

            $table->foreign('store_id')->references('id')->on('stores')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('store_category_id');

            $table->foreign('store_category_id')->references('id')->on('store_categories')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('supplier_id');

            $table->foreign('supplier_id')->references('id')->on('suppliers')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('material_setup_id');

            $table->foreign('material_setup_id')->references('id')->on('material_setups')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->decimal('buying_qty', 8, 2); 

            $table->unsignedBigInteger('unit_id');

            $table->foreign('unit_id')->references('id')->on('units')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->decimal('unit_price', 10, 2);

            $table->text('description')->nullable();

            $table->string('purpose')->nullable();

            $table->string('challan_no')->nullable();

            $table->decimal('buying_price', 12, 2);

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
        Schema::dropIfExists('purchase_items');
    }
};
