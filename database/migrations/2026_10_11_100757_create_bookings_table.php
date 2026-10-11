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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('booking_reference', 30)->unique();
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('customer_name');
            $table->string('customer_phone', 25);
            $table->string('customer_email')->nullable();
            $table->string('service_title')->nullable();
            $table->date('booking_date');
            $table->string('booking_time_slot', 50);
            $table->text('booking_address')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->enum('status', ['pending', 'confirmed', 'completed', 'cancelled'])->default('pending');
            $table->timestamps();

            // Performance indexes
            $table->index(['vendor_id', 'booking_date']);
            $table->index(['vendor_id', 'status']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
