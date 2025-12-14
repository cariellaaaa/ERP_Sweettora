<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('warehouse_id')->nullable()->index();
            $table->string('batch_number')->nullable()->index();
            $table->integer('quantity')->default(0);
            $table->integer('reserved')->default(0);
            $table->integer('available')->default(0);
            $table->double('unit_cost')->default(0);
            $table->double('total_value')->default(0);
            $table->date('expiry_date')->nullable();
            $table->string('location')->nullable();
            $table->integer('reorder_level')->default(0);
            $table->integer('max_stock')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'Expired', 'Damaged'])->default('Active');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inventories');
    }
};
