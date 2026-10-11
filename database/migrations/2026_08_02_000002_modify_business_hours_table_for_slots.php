<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('business_hours', function (Blueprint $table) {
            $table->index('vendor_id');
            $table->dropUnique('vendor_business_hours_unique');
            $table->integer('slot_order')->default(0)->after('specific_date');
        });
    }

    public function down()
    {
        Schema::table('business_hours', function (Blueprint $table) {
            $table->dropColumn('slot_order');
            $table->unique(['vendor_id', 'day_of_week', 'specific_date'], 'vendor_business_hours_unique');
            $table->dropIndex(['vendor_id']);
        });
    }
};
