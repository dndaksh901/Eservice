<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('business_hours', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('vendor_id');
            $table->tinyInteger('day_of_week')->nullable()->comment('0=Sunday,1=Monday,...6=Saturday');
            $table->date('specific_date')->nullable()->comment('Override or special day schedule');
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->boolean('is_closed')->default(false);
            $table->timestamps();

            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->unique(['vendor_id', 'day_of_week', 'specific_date'], 'vendor_business_hours_unique');
        });
    }

    public function down()
    {
        Schema::dropIfExists('business_hours');
    }
};
