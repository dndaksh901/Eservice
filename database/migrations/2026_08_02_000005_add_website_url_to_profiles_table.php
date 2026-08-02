<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('profiles', 'website_url')) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->string('website_url')->nullable()->after('address');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('profiles', 'website_url')) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->dropColumn('website_url');
            });
        }
    }
};
