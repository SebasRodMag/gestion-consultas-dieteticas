<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bonos', function (Blueprint $table) {
            $table->id('id_bono');
            $table->unsignedBigInteger('id_paciente');
            $table->integer('total_consultas');
            $table->integer('consultas_utilizadas')->default(0);
            $table->dateTime('fecha_compra')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('fecha_expiracion')->nullable();

            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('bonos');
    }
};
