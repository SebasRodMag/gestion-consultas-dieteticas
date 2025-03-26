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
        Schema::create('CONSULTA', function (Blueprint $table) {
            $table->id('id_consulta');
            $table->unsignedBigInteger('id_especialista');
            $table->unsignedBigInteger('id_paciente');
            $table->enum('tipo_consulta', ['presencial', 'telemática']);
            $table->dateTime('fecha_hora_consulta');
            $table->enum('estado', ['pendiente', 'realizada', 'cancelada'])->default('pendiente');
            $table->text('comentario')->nullable();
            $table->foreign('id_especialista')->references('id_especialista')->on('ESPECIALISTA')->onDelete('cascade');
            $table->foreign('id_paciente')->references('id_paciente')->on('PACIENTE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consulta');
    }
};
