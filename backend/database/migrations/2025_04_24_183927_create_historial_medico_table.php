<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('historial_medico', function (Blueprint $table) {
            $table->id('id_historial');
            $table->unsignedBigInteger('id_paciente');
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_hora_ultima_modificacion')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('historial_medico');
    }
};

