<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('device_sequences', function (Blueprint $table) {
            $table->id();
            $table->string('sequence_name', 50)->unique();
            $table->unsignedBigInteger('next_value');
            $table->timestamps();
        });

        // Seed initial sequence for device_number
        DB::table('device_sequences')->insert([
            'sequence_name' => 'device_number',
            'next_value' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('device_sequences');
    }
};
