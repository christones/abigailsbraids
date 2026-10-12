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
        Schema::create('product_orders', function (Blueprint $table) {
            $table->id();
            $table->string('reference', 20)->unique();
            $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
            $table->string('product_name');
            $table->decimal('unit_price', 8, 2);
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('total_price', 10, 2);
            $table->string('client_name');
            $table->string('client_email');
            $table->string('client_phone', 30);
            $table->text('notes')->nullable();
            $table->string('status', 20)->default('pending');
            $table->timestamps();

            $table->index(['product_id', 'client_email', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_orders');
    }
};
