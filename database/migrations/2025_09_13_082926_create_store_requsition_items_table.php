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
        Schema::create('store_requsition_items', function (Blueprint $table) {

            $table->id();

            $table->string('requsition_no', 50);

            $table->unsignedBigInteger('store_requsition_id');
            
            $table->foreign('store_requsition_id')->references('id')->on('store_requsitions')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('material_setup_id');

            $table->foreign('material_setup_id')->references('id')->on('material_setups')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->decimal('quantity', 8, 2);

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
        Schema::dropIfExists('store_requsition_items');
    }
};
