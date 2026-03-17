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
            $table->unsignedBigInteger('sbp_id')->nullable()->after('id');
            $table->foreign('sbp_id')->references('id')->on('sbp')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lpt', function (Blueprint $table) {
            $table->dropForeign(['sbp_id']);
            $table->dropColumn('sbp_id');
        });
    }
};
