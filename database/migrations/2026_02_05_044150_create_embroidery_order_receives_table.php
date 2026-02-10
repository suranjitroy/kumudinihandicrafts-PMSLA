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
        Schema::create('embroidery_order_receives', function (Blueprint $table) {

            $table->id();

            $table->date('receive_date');

            $table->unsignedBigInteger('embroidery_order_id');

            $table->foreign('embroidery_order_id')->references('id')->on('embroidery_orders')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->integer('receive_quantity');

            $table->string('remark')->nullable();

            $table->tinyInteger('status')->comment('1=Received');  

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
        Schema::dropIfExists('embroidery_order_receives');
    }
};
