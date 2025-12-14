<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventory_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('warehouse_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->string('transaction_code')->unique()->index();
            $table->enum('transaction_type', ['In', 'Out', 'Adjustment', 'Transfer', 'Return'])->index();
            $table->string('reference_type')->nullable();
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('quantity_before')->default(0);
            $table->integer('quantity_after')->default(0);
            $table->double('unit_cost')->default(0);
            $table->double('total_cost')->default(0);
            $table->string('batch_number')->nullable();
            $table->date('transaction_date')->default(now());
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventory_transactions');
    }
};
