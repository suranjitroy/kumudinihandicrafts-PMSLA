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
        Schema::create('material_setups', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('store_id');

            $table->foreign('store_id')->references('id')->on('stores')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('store_category_id');

            $table->foreign('store_category_id')->references('id')->on('store_categories')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->string('material_name',40);

            $table->double('quantity');

            $table->unsignedBigInteger('unit_id');

            $table->foreign('unit_id')->references('id')->on('units')
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
        Schema::dropIfExists('material_setups');
    }
};
