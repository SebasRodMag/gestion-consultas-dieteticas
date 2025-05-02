<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id('id_consulta');
            $table->unsignedBigInteger('id_paciente');
            $table->unsignedBigInteger('id_especialista');
            $table->enum('tipo_consulta', ['presencial', 'telemática']);
            $table->dateTime('fecha_hora_consulta');
            $table->enum('estado', ['pendiente', 'realizada', 'cancelada', 'no_realizada'])->default('pendiente');
            $table->text('comentario')->nullable();
            $table->boolean('pagada')->default(false);
            $table->enum('tipo_pago', ['ninguno', 'individual', 'bono'])->default('ninguno');

            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes')->onDelete('cascade');
            $table->foreign('id_especialista')->references('id_especialista')->on('especialistas')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('consultas');
    }
};
