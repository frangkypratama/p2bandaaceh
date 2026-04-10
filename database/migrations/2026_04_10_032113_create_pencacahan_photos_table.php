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
        Schema::create('pencacahan_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pencacahan_sbp_id')->constrained('pencacahan_sbp')->onDelete('cascade');
            $table->string('path');
            $table->string('filename');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencacahan_photos');
    }
};
