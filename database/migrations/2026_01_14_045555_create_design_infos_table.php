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
        Schema::create('design_infos', function (Blueprint $table) {

            $table->id();
            
            $table->date('design_entry_date');

            $table->string('design_no')->unique();

            $table->string('product_name');

            $table->string('design_name');
            
            $table->string('design_code')->unique();

            $table->text('description')->nullable();

            $table->unsignedBigInteger('material_setup_id');

            $table->foreign('material_setup_id')->references('id')->on('material_setups')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->string('design_image')->nullable();

            $table->text('remarks')->nullable();

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
        Schema::dropIfExists('design_infos');
    }
};
