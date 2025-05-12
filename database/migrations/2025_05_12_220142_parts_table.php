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
    Schema::create('parts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('category_id')->constrained('part_categories');
        $table->string('name'); // e.g., Sport Handle, Classic Handle
        $table->text('description')->nullable();
        $table->decimal('price', 10, 2);
        $table->integer('stock')->default(0);
        $table->string('image')->nullable();
        $table->json('specifications')->nullable(); // For additional specs
        $table->boolean('is_active')->default(true);
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
