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
        Schema::create('sliders', function (Blueprint $table) {
              $table->id();

            $table->string('name');

             $table->enum('state', ['published', 'not_published'])->default('not_published');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Polymorphic relation
            $table->string('sliderable_type')->nullable();
            $table->unsignedBigInteger('sliderable_id')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // Index for polymorphic relation
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sliders');
    }
};
