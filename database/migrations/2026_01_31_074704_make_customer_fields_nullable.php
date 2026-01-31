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
        Schema::table('customers', function (Blueprint $table) {
            $table->enum('type', ['Pemerintah', 'Swasta'])->nullable()->change();
            $table->foreignId('province_id')->nullable()->change();
            $table->foreignId('categories_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->enum('type', ['Pemerintah', 'Swasta'])->nullable(false)->change();
            $table->foreignId('province_id')->nullable(false)->change();
            $table->foreignId('categories_id')->nullable(false)->change();
        });
    }
};