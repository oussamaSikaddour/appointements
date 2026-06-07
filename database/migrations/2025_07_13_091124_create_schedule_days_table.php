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
        Schema::create('schedule_days', function (Blueprint $table) {
            $table->id();

            $table->foreignId('doctor_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->foreignId('schedule_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->date('day_at');

            $table->unsignedInteger('available_number');
            $table->unsignedInteger('confirmed_number')->default(0);
            $table->foreignId('specialty_id')
                  ->constrained('field_specialties')
                  ->cascadeOnDelete();
            $table->foreignId('appointments_location_id')
                  ->nullable()
                  ->constrained('establishments')
                  ->nullOnDelete();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_days');
    }
};
