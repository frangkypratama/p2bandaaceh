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
        Schema::create('pencacahan_sbp', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pencacahan_id');
            $table->unsignedBigInteger('sbp_id');
            $table->timestamps();

            $table->foreign('pencacahan_id')->references('id')->on('pencacahan')->onDelete('cascade');
            $table->foreign('sbp_id')->references('id')->on('sbp')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pencacahan_sbp');
    }
};
