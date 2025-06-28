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
    Schema::table('orders', function (Blueprint $table) {
        $table->date('expected_completion_date')->nullable()->after('status');
    });
    }

    public function down(): void
    {
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('expected_completion_date');
    });
    }

};
