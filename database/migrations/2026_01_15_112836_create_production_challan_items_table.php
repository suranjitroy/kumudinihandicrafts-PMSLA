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
        Schema::create('production_challan_items', function (Blueprint $table) {

            $table->id();

            $table->string('pro_challan_no');

            $table->unsignedBigInteger('production_challan_id');

            $table->foreign('production_challan_id')->references('id')->on('production_challans')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('size_id');

            $table->foreign('size_id')->references('id')->on('sizes')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->integer('assign_quantity');

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
        Schema::dropIfExists('production_challan_items');
    }
};
