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
        Schema::create('transactions_items', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id');
            $table->string('product_id'); // Or foreignId if using product relationships
            $table->integer('quantity');
            $table->decimal('price', 10, 2); // Adjust precision as needed
            $table->timestamps(); // This will create `created_at` and `updated_at` columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
