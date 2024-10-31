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
        Schema::create('multimedia', function (Blueprint $table) {
            $table->id();
            $table->string('file_name');
            $table->string('file_path');
            $table->enum('file_type', ['VIDEO', 'PDF', 'IMAGEN'])->nullable();
            $table->string('mime_type', 50)->nullable();
            $table->integer('size')->nullable();
            $table->unsignedBigInteger('model_id');
            $table->enum('model_type', ['raffles', 'tickets'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('multimedia');
    }
};
