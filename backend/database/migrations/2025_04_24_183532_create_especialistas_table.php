<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('especialistas', function (Blueprint $table) {
            $table->id('id_especialista');
            $table->unsignedBigInteger('id_usuario')->unique();
            $table->string('especialidad', 100);

            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('especialistas');
    }
};
