<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations to optimize database performance for high traffic.
     */
    public function up(): void
    {
        if (Schema::hasTable('profiles')) {
            Schema::table('profiles', function (Blueprint $table) {
                // Spatial bounding box and filter composite index
                $table->index(['occupation_id', 'latitude', 'longitude'], 'idx_profiles_occ_lat_lng');
                $table->index(['profile_status', 'occupation_id'], 'idx_profiles_status_occ');
            });
        }

        if (Schema::hasTable('reviews')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->index(['profile_id', 'rating'], 'idx_reviews_profile_rating');
                $table->index(['vendor_id'], 'idx_reviews_vendor_id');
            });
        }

        if (Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->index(['vendor_id', 'is_read'], 'idx_notif_vendor_read');
            });
        }

        if (Schema::hasTable('messages')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->index(['sender_id', 'receiver_id', 'created_at'], 'idx_messages_conversation_time');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('profiles')) {
            Schema::table('profiles', function (Blueprint $table) {
                $table->dropIndex('idx_profiles_occ_lat_lng');
                $table->dropIndex('idx_profiles_status_occ');
            });
        }

        if (Schema::hasTable('reviews')) {
            Schema::table('reviews', function (Blueprint $table) {
                $table->dropIndex('idx_reviews_profile_rating');
                $table->dropIndex('idx_reviews_vendor_id');
            });
        }

        if (Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->dropIndex('idx_notif_vendor_read');
            });
        }

        if (Schema::hasTable('messages')) {
            Schema::table('messages', function (Blueprint $table) {
                $table->dropIndex('idx_messages_conversation_time');
            });
        }
    }
};
