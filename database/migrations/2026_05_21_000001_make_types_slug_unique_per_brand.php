<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Change slug from globally unique to unique per brand.
     * This aligns the DB constraint with the app's logic:
     * types are scoped to brands, so two brands can have types
     * with the same name/slug (e.g., Samsung "Galaxy" and LG "Galaxy").
     */
    public function up(): void
    {
        Schema::table('types', function (Blueprint $table) {
            $table->dropUnique('types_slug_unique');
            $table->unique(['slug', 'brand_id'], 'types_slug_brand_id_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('types', function (Blueprint $table) {
            $table->dropUnique('types_slug_brand_id_unique');
            $table->unique('slug', 'types_slug_unique');
        });
    }
};
