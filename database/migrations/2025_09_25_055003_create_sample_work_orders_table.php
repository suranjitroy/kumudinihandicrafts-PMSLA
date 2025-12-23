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
        Schema::create('sample_work_orders', function (Blueprint $table) {

            $table->id();

            $table->date('order_entry_date');

            $table->string('sample_order_no', 50);

            $table->unsignedBigInteger('master_info_id');

            $table->foreign('master_info_id')->references('id')->on('master_infos')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedBigInteger('item_id');

            $table->foreign('item_id')->references('id')->on('items')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->decimal('grand_total_quantity', 8, 2);

            $table->decimal('grand_total_yeard', 15, 2);

            $table->longText('purpose');

            $table->tinyInteger('status')->comment('0=Pending, 1=Approved, 2=Recomended');

            $table->unsignedBigInteger('approved_by')->nullable();

            $table->foreign('approved_by')->references('id')->on('users')->cascadeOnUpdate()->restrictOnDelete();

            $table->timestamp('approved_at')->nullable();

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
        Schema::dropIfExists('sample_work_orders');
    }
};
