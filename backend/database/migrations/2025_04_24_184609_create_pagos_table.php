<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');
            $table->unsignedBigInteger('id_paciente');
            $table->unsignedBigInteger('id_consulta')->nullable();
            $table->unsignedBigInteger('id_bono')->nullable();
            $table->decimal('cantidad', 6, 2);
            $table->enum('metodo_pago', ['tarjeta', 'transferencia', 'efectivo'])->default('tarjeta');
            $table->enum('estado_pago', ['pendiente', 'completado', 'fallido'])->default('pendiente');

            $table->foreign('id_paciente')->references('id_paciente')->on('pacientes')->onDelete('cascade');
            $table->foreign('id_consulta')->references('id_consulta')->on('consultas')->onDelete('set null');
            $table->foreign('id_bono')->references('id_bono')->on('bonos')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            
            // Índices adicionales para las claves foráneas
            $table->index(['id_paciente', 'id_consulta', 'id_bono']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('pagos');
    }
};
