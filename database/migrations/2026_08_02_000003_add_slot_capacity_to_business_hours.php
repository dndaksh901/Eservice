<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('business_hours', function (Blueprint $table) {
            $table->integer('slot_capacity')->default(1)->after('slot_order');
        });
    }

    public function down()
    {
        Schema::table('business_hours', function (Blueprint $table) {
            $table->dropColumn('slot_capacity');
        });
    }
};
