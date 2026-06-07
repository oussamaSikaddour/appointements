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
        Schema::create('about_us', function (Blueprint $table) {
            $table->id();
            $table->string('title_fr'); // French title
            $table->string('title_ar'); // Arabic title
            $table->string('title_en'); // Arabic title
            $table->text('description_fr'); // French description
            $table->text('description_ar'); // Arabic description
            $table->text('description_en'); // Arabic description
            $table->timestamps(); // created_at and updated_at columns
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_us');
    }
};
