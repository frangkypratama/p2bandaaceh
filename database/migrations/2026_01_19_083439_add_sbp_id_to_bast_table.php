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
        Schema::table('bast', function (Blueprint $table) {
            $table->foreignId('sbp_id')->constrained('sbp')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bast', function (Blueprint $table) {
            $table->dropForeign(['sbp_id']);
            $table->dropColumn('sbp_id');
        });
    }
};
