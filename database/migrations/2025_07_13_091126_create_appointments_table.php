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
        Schema::create('appointments', function (Blueprint $table) {
       $table->id();

            $table->foreignId('patient_id')
                ->constrained('medical_files')
                ->onDelete('cascade');
            $table->foreignId('doctor_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');
            $table->foreignId('schedule_day_id')
                ->nullable()
                ->constrained('schedule_days')
                ->onDelete('set null');
            $table->foreignId('appointments_location_id')
                ->nullable()
                ->constrained('establishments')
                ->onDelete('set null');
            $table->enum('type', ['initial', 'follow-up'])->default('initial');
            $table->enum('initiator', ['doctor', 'patient'])->default('patient');
            $table->date('day_at');
            $table->foreignId('specialty_id')
                ->nullable()
                ->constrained('field_specialties')
                ->onDelete('set null');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
