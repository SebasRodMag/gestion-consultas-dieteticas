<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id('id_paciente');
            $table->unsignedBigInteger('id_usuario')->unique();
            $table->date('fecha_alta');
            $table->date('fecha_baja')->nullable();
            $table->enum('estado', ['pendiente', 'activo', 'finalizado'])->default('pendiente');

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pacientes');
    }
};
