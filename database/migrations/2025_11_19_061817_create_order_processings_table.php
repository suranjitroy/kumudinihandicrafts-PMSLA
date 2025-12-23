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
        Schema::create('order_processings', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('production_work_order_id');

            $table->foreign('production_work_order_id')->references('id')->on('production_work_orders')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('process_section_id');

            $table->foreign('process_section_id')->references('id')->on('process_sections')->cascadeOnUpdate()->restrictOnDelete();

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
        Schema::dropIfExists('order_processings');
    }
};
