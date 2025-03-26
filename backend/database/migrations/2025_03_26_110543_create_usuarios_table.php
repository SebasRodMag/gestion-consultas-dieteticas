<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('USUARIOS', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 100);
            $table->string('apellidos', 150);
            $table->string('dni_usuario', 9)->unique();
            $table->string('email', 100)->unique();
            $table->date('fecha_nacimiento');
            $table->string('telefono', 15)->nullable();
            $table->enum('rol', ['paciente', 'especialista', 'usuario', 'administrador'])->default('usuario');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('USUARIOS');
    }
};
