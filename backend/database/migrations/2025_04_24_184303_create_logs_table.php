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
            $table->dateTime('fecha_log')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('set null');
        });
    }

    public function down(): void {
        Schema::dropIfExists('logs');
    }
};
