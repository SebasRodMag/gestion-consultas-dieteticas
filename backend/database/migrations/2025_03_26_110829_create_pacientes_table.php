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
        Schema::create('PACIENTE', function (Blueprint $table) {
            $table->id('id_paciente');
            $table->unsignedBigInteger('id_usuario')->unique();
            $table->date('fecha_alta');
            $table->date('fecha_baja')->nullable();
            $table->foreign('id_usuario')->references('id_usuario')->on('USUARIOS')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('PACIENTE');
    }
};
