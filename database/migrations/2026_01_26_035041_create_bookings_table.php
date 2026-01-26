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
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('username')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('nights');
            $table->integer('rooms');
            $table->decimal('fare_per_night', 10, 2);
            $table->decimal('tax_percentage', 5, 2)->default(10.00);
            $table->decimal('total_fare', 10, 2);
            $table->decimal('total_tax', 10, 2);
            $table->decimal('grand_total', 10, 2);
            $table->string('status')->default('pending'); // pending, confirmed, cancelled, completed
            $table->text('notes')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('check_in');
            $table->index('check_out');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
