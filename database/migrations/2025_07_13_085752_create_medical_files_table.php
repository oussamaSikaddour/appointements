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
        Schema::create('medical_files', function (Blueprint $table) {
            $table->id();

            $table->string('last_name_fr');
            $table->string('first_name_fr');
            $table->string('last_name_ar')->nullable();
            $table->string('first_name_ar')->nullable();

            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            $table->string('code'); // patient code or file code
            $table->string('birth_place_fr')->nullable();
            $table->string('birth_place_ar')->nullable();
            $table->string('birth_place_en')->nullable();
            $table->date('birth_date');
            $table->string('address_fr')->nullable();
            $table->string('address_ar')->nullable();
            $table->string('address_en')->nullable();
            $table->string('tel')->nullable();
            $table->unsignedBigInteger('opened_by')->nullable();
            $table->string('insurance_number')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign key to users table
            $table->foreign('opened_by')
                  ->references('id')
                  ->on('users')
                  ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_files');
    }
};
