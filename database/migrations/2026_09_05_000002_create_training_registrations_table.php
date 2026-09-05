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
        Schema::create('training_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->cascadeOnDelete();
            $table->string('candidate_name');
            $table->string('candidate_email');
            $table->string('candidate_phone');
            $table->date('preferred_date');
            $table->string('experience_level')->nullable();
            $table->text('message')->nullable();
            $table->string('status')->default('pending');
            $table->timestamps();

            $table->index('preferred_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_registrations');
    }
};
