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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_category_id')->index();
            $table->unsignedBigInteger('unit_id')->index();
            $table->unsignedBigInteger('vendor_id')->index()->nullable();
            $table->enum('type', ['raw', 'product']);
            $table->string('name');
            $table->string('code');
            $table->string('barcode')->nullable();
            $table->double('price');
            $table->double('cost');
            $table->timestamp('expired_date')->nullable();
            $table->text('description')->nullable();
            $table->text('tags')->nullable();
            $table->text('image')->nullable();
            $table->integer('stock')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
