<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->dropColumn('notes');
            $table->dropForeign(['admin_id']);
            $table->dropColumn('admin_id');
        });
    }

    public function down(): void
    {
        Schema::table('devices', function (Blueprint $table) {
            $table->text('notes')->nullable();
            $table->foreignId('admin_id')->nullable()->constrained('users');
        });
    }
};
