<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bom_items', function (Blueprint $table) {
            $table->id();

            // FK manual (WAJIB untuk SQLite)
            $table->unsignedBigInteger('bill_of_material_id');
            $table->unsignedBigInteger('product_id');

            $table->decimal('quantity', 10, 2);
            $table->decimal('cost', 10, 2);
            $table->decimal('total', 10, 2)->nullable();
            $table->timestamps();

            // Foreign key manual
            $table->foreign('bill_of_material_id')
                ->references('id')->on('bill_of_materials')
                ->onDelete('cascade');

            $table->foreign('product_id')
                ->references('id')->on('products')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bom_items');
    }
};
