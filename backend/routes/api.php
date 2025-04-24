<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\EspecialistaController;
use App\Http\Controllers\ConsultaController;

Route::prefix('usuarios')->group(function () {
    Route::get('/', [UsuarioController::class, 'index']); // Obtener todos los usuarios
    Route::post('/', [UsuarioController::class, 'store']); // Crear un nuevo usuario
    Route::get('{id}', [UsuarioController::class, 'show']); // Obtener un usuario específico
    Route::put('{id}', [UsuarioController::class, 'update']); // Actualizar un usuario
    Route::delete('{id}', [UsuarioController::class, 'destroy']); // Eliminar un usuario
});

Route::prefix('pacientes')->group(function () {
    Route::get('/', [PacienteController::class, 'index']); // Obtener todos los pacientes
    Route::post('/', [PacienteController::class, 'store']); // Crear un nuevo paciente
    Route::get('{id}', [PacienteController::class, 'show']); // Obtener un paciente específico
    Route::put('{id}', [PacienteController::class, 'update']); // Actualizar un paciente
    Route::delete('{id}', [PacienteController::class, 'destroy']); // Eliminar un paciente

    // Rutas adicionales para obtener las consultas de un paciente
    Route::get('{id}/consultas', [PacienteController::class, 'consultas']); // Consultas de un paciente
});

Route::prefix('especialistas')->group(function () {
    Route::get('/', [EspecialistaController::class, 'index']); // Obtener todos los especialistas
    Route::post('/', [EspecialistaController::class, 'store']); // Crear un nuevo especialista
    Route::get('{id}', [EspecialistaController::class, 'show']); // Obtener un especialista específico
    Route::put('{id}', [EspecialistaController::class, 'update']); // Actualizar un especialista
    Route::delete('{id}', [EspecialistaController::class, 'destroy']); // Eliminar un especialista
});

Route::prefix('consultas')->group(function () {
    Route::get('/', [ConsultaController::class, 'index']); // Obtener todas las consultas
    Route::post('/', [ConsultaController::class, 'store']); // Crear una nueva consulta
    Route::get('{id}', [ConsultaController::class, 'show']); // Obtener una consulta específica
    Route::put('{id}', [ConsultaController::class, 'update']); // Actualizar una consulta
    Route::delete('{id}', [ConsultaController::class, 'destroy']); // Eliminar una consulta

    // Ruta para realizar el pago de una consulta
    Route::post('{id}/pagar', [ConsultaController::class, 'pagar']); // Realizar el pago de una consulta
    // Actualizar el estado de la consulta a 'cancelada'
    Route::patch('{id}/cancelar', [ConsultaController::class, 'cancelar']); // Cancelar consulta
    // Obtener link a la videollamada
    Route::get('{id}/videollamada', [ConsultaController::class, 'videollamada']); // Obtener link videollamada
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
