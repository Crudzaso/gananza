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
        Schema::table('lotteries', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->string('url_imagen')->nullable()->change();
            
            $table->string('slug')->unique()->after('name');
        }); 
       }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lotteries', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
            $table->string('url_imagen')->nullable(false)->change();
            $table->dropColumn('slug');
        });
    }
};
