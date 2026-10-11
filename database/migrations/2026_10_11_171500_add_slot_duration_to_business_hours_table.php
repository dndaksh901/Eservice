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
        if (!Schema::hasColumn('business_hours', 'slot_duration')) {
            Schema::table('business_hours', function (Blueprint $table) {
                $table->unsignedInteger('slot_duration')->default(30)->after('special_dates');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('business_hours', 'slot_duration')) {
            Schema::table('business_hours', function (Blueprint $table) {
                $table->dropColumn('slot_duration');
            });
        }
    }
};
