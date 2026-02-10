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
        Schema::table('lpt', function (Blueprint $table) {
            $table->unsignedInteger('nomor_lpt_int')->nullable()->after('nomor_lpt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lpt', function (Blueprint $table) {
            $table->dropColumn('nomor_lpt_int');
        });
    }
};