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
        Schema::table('users', function (Blueprint $table) {
       $table->foreign('establishment_id')
      ->references('id')
      ->on('establishments')
      ->nullOnDelete();
       $table->foreign('appointments_location_id')
      ->references('id')
      ->on('establishments')
      ->nullOnDelete();
       $table->foreign('service_id')
      ->references('id')
      ->on('services')
      ->nullOnDelete();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['establishment_id']);
            $table->dropForeign(['appointments_location_id']);
            $table->dropForeign(['service_id']);
        });
    }
};
