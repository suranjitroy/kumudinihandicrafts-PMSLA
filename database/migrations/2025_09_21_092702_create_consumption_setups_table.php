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
        Schema::create('consumption_setups', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('item_id');

            $table->foreign('item_id')->references('id')->on('items')
            ->cascadeOnUpdate()->restrictOnDelete();
            
            $table->unsignedBigInteger('material_setup_id');

            $table->foreign('material_setup_id')->references('id')->on('material_setups')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('bahar_id');

            $table->foreign('bahar_id')->references('id')->on('bahars')
            ->cascadeOnUpdate()->restrictOnDelete();

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
        Schema::dropIfExists('consumption_setups');
    }
};
