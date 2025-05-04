<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('entradas_historial', function (Blueprint $table) {
            $table->id('id_entrada');
            $table->unsignedBigInteger('id_historial');
            $table->unsignedBigInteger('id_consulta')->nullable();
            $table->text('descripcion');
            $table->timestamp('fecha_entrada')->useCurrent();

            $table->foreign('id_historial')->references('id_historial')->on('historial_medicos')->onDelete('cascade');
            $table->foreign('id_consulta')->references('id_consulta')->on('consultas')->onDelete('set null');
            

            $table->index(['id_historial', 'id_consulta']);
            

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void {
        Schema::dropIfExists('entradas_historial');
    }
};
