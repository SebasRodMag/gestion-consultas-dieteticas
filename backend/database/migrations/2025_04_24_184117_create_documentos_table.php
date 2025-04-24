<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('documentos', function (Blueprint $table) {
            $table->id('id_documento');
            $table->unsignedBigInteger('id_historial');
            $table->string('nombre_archivo', 255);
            $table->text('ruta_archivo');
            $table->dateTime('fecha_hora_subida')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->dateTime('fecha_hora_ultima_modificacion')->nullable();

            $table->foreign('id_historial')->references('id_historial')->on('historial_medico')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('documentos');
    }
};
