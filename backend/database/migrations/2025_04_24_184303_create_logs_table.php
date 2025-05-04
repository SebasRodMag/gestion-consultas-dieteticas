<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('logs', function (Blueprint $table) {
            $table->id('id_log');
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->string('accion', 255);
            $table->text('descripcion')->nullable();
            $table->timestamp('fecha_log')->useCurrent();
            $table->string('tabla_afectada')->nullable();
            $table->unsignedBigInteger('id_registro_afectado')->nullable();
            $table->foreign('id_usuario')->references('id')->on('usuarios')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['id_usuario', 'accion', 'fecha_log']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('logs');
    }
};
