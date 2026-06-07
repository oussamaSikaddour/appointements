<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->text('message'); // Notification message
            $table->boolean('active')->default(true); // Whether the notification is active or not
            $table->string('for_type'); // The type of the target (e.g., User, Admin, etc.)
            $table->unsignedBigInteger('targetable_id'); // The ID of the target entity
            $table->string('targetable_type'); // The type of the target entity (polymorphic)
            $table->timestamps(); // Created at and Updated at
            // Adding indexes for polymorphic relationship (targetable_id, targetable_type)
            $table->index(['targetable_id', 'targetable_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
