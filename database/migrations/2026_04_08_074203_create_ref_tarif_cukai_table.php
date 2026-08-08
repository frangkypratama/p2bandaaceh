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
        Schema::create('ref_tarif_cukai', function (Blueprint $table) {
            $table->id();
            $table->string('jenis');
            $table->string('golongan');
            $table->decimal('hje_min', 15, 2);
            $table->decimal('hje_max', 15, 2)->nullable();
            $table->decimal('tarif', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ref_tarif_cukai');
    }
};
