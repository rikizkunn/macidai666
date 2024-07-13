<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Products;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->string('product_name');
            $table->string('product_image')->nullable();
            $table->text('product_description')->nullable();
            $table->unsignedBigInteger('category_id'); // Use unsignedBigInteger for consistency
            $table->decimal('price', 10, 2);
            $table->integer('stock');
            $table->string('slug')->nullable();
            $table->string('option')->nullable();
            $table->string('brand')->nullable();
            $table->timestamps(); // created_at and updated_at

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
