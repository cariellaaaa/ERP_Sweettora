<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_adjustment_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_adjustment_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->integer('quantity_before')->default(0);
            $table->integer('quantity_adjusted')->default(0);
            $table->integer('quantity_after')->default(0);
            $table->double('unit_cost')->default(0);
            $table->double('total_cost')->default(0);
            $table->string('batch_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('stock_adjustment_id')->references('id')->on('stock_adjustments')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_adjustment_details');
    }
};
