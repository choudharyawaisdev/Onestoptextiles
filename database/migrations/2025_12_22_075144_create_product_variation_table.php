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
        Schema::create('product_variations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->string('size')->nullable(); // can store "71x95" or any custom size
            $table->string('color')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('finish')->nullable(); // finish/elastic
            $table->text('description')->nullable(); // variant notes
            $table->json('images')->nullable(); // variant images
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
