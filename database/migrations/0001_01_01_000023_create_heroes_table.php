<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heros', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title_ar'); // Title in Arabic
            $table->string('title_fr'); // Title in French
            $table->string('title_en'); // Title in English
            $table->string('sub_title_ar'); // Subtitle in Arabic
            $table->string('sub_title_fr'); // Subtitle in French
            $table->string('sub_title_en'); // Subtitle in English
            $table->timestamps(); // Created at and Updated at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('heros');
    }
};
