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
            $table->string('slug')->unique();
            $table->string('room_type'); // Room or Suite
            
            // Pricing
            $table->decimal('fare', 10, 2);
            $table->decimal('offer_fare', 10, 2)->nullable();
            $table->decimal('cancellation_fee', 10, 2)->default(0);
            
            // Capacity & Size
            $table->integer('total_adult');
            $table->integer('total_child');
            $table->string('size'); // e.g., 500 sqft
            
            // Details
            $table->text('amenities')->nullable(); // JSON or Comma separated
            $table->text('facilities')->nullable();
            $table->text('keywords')->nullable();
            $table->longText('description')->nullable();
            $table->longText('cancellation_policy')->nullable();
            
            // Images & Status
            $table->string('main_image')->nullable();
            $table->text('gallery_images')->nullable(); // Multiple images path
            $table->boolean('is_featured')->default(0);
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
