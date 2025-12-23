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
        Schema::create('purchase_requsitions', function (Blueprint $table) {

            $table->id();

            $table->date('pur_requsition_date');

            $table->string('pur_requsition_no', 50);

            $table->unsignedBigInteger('section_id');

            $table->foreign('section_id')->references('id')->on('sections')
            ->cascadeOnUpdate()->restrictOnDelete();

            $table->decimal('total', 15, 2);

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
        Schema::dropIfExists('purchase_requsitions');
    }
};
