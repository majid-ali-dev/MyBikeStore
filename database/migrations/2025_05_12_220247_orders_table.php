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
     Schema::create('orders', function (Blueprint $table) {
       $table->id();
       $table->foreignId('user_id')->constrained('users');
       $table->foreignId('brand_id')->nullable()->constrained('bikes');
       $table->decimal('total_amount', 10, 2);
       $table->enum('status', ['pending', 'processing', 'completed', 'delivered', 'cancelled'])->default('pending');
       $table->string('payment_method')->nullable();
       $table->boolean('payment_status')->default(false);
       $table->decimal('advance_payment', 10, 2)->default(0);
       $table->text('shipping_address')->nullable();
       $table->text('notes')->nullable();
       $table->timestamps();
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
