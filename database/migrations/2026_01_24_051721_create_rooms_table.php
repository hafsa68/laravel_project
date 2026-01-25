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
        Schema::create('rooms', function (Blueprint $table) {
           $table->id();
            $table->string('name');
            $table->decimal('fare', 10, 2);
            $table->integer('adults');
            $table->integer('children');
             $table->enum('is_featured', ['Featured', 'Unfeatured'])->default('Unfeatured');
            $table->enum('room_type', ['Room', 'Suite'])->default('Room');
            $table->enum('status', ['Enabled', 'Disabled'])->default('Enabled');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
