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
        Schema::create('receive_item_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('receive_item_id')->index();
            $table->unsignedBigInteger('product_id')->index();
            $table->unsignedBigInteger('unit_id')->index();
            $table->integer('quantity')->default(0);
            $table->integer('received')->default(0);
            $table->double('price');
            $table->double('paid');
            $table->double('subtotal');
            $table->double('tax')->default(0);
            $table->double('tax_value')->default(0);
            $table->double('total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receive_item_details');
    }
};
