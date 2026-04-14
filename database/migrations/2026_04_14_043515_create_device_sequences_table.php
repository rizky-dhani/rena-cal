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

        // Smart seeding: check for existing max device number
        $maxNumber = DB::table('devices')
            ->where('device_number', 'REGEXP', '^RENA-[0-9]+$')
            ->selectRaw('MAX(CAST(SUBSTRING(device_number, 6) AS UNSIGNED)) as max_num')
            ->value('max_num');

        $nextValue = $maxNumber ? (int) $maxNumber + 1 : 1;

        DB::table('device_sequences')->insert([
            'sequence_name' => 'device_number',
            'next_value' => $nextValue,
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
