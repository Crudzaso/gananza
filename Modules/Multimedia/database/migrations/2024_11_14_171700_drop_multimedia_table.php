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
        Schema::dropIfExists('multimedia');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('multimedia', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_path');
            $table->enum('file_type', ['VIDEO', 'PDF', 'IMAGEN'])->nullable();
            $table->string('mime_type', 50)->nullable();
            $table->integer('size')->nullable();
            $table->foreignId('raffle_id')->constrained('raffles')->onDelete('cascade');
            $table->timestamps();
        });
    }
};
