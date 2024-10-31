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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('raffle_id')->constrained('raffles');
            $table->foreignId('user_id')->constrained('users');
            $table->string('ticket_number', 10);
            $table->dateTime('purchase_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('verification_code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
