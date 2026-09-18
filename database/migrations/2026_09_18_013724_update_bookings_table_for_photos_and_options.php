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
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('hair_length');
            $table->string('hair_photo_path')->nullable()->after('preferred_time');
            $table->string('inspiration_photo_path')->nullable()->after('hair_photo_path');
            $table->json('selected_options')->nullable()->after('inspiration_photo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['hair_photo_path', 'inspiration_photo_path', 'selected_options']);
            $table->string('hair_length')->nullable();
        });
    }
};
