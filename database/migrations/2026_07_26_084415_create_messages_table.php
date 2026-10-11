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
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id');
            $table->string('sender_type'); // App\Models\User or App\Models\Vendor
            $table->unsignedBigInteger('receiver_id');
            $table->string('receiver_type');
            $table->text('message')->nullable();
            $table->string('attachment')->nullable();
            $table->string('attachment_type')->nullable(); // image, file, location
            $table->boolean('is_seen')->default(false);
            $table->timestamps();

            // Note: Since polymorphic relationships are used, we won't add foreign key constraints 
            // directly here for sender_id/receiver_id without specific tables.
            $table->index(['sender_id', 'sender_type']);
            $table->index(['receiver_id', 'receiver_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
