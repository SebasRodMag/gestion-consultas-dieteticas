<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('HISTORIAL_MEDICO', function (Blueprint $table) {
            $table->id('id_historial');
            $table->unsignedBigInteger('id_paciente');
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_hora_ultima_modificacion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreign('id_paciente')->references('id_paciente')->on('PACIENTE')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('HISTORIAL_MEDICO');
    }
};
