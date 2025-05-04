<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UsuarioController,
    PacienteController,
    EspecialistaController,
    ConsultaController,
    HistorialMedicoController,
    DocumentoController,
    BonosController,
    PagosController,
    LogController,
    VideollamadaController,
    EntradaHistorialController
};

// Rutas públicas (si las hubiera)

// Rutas protegidas por autenticación Sanctum
Route::middleware('auth:sanctum')->group(function () {

    // Rutas para administradores
    Route::middleware('role:administrador')->group(function () {
        Route::apiResources([
            'usuarios' => UsuarioController::class,
            'especialistas' => EspecialistaController::class,
            'pacientes' => PacienteController::class,
            'consultas' => ConsultaController::class,
            'historialMedico' => HistorialMedicoController::class,
            'documentos' => DocumentoController::class,
            'bonos' => BonosController::class,
            'pagos' => PagosController::class
        ]);
    });

    // Rutas para especialistas
    Route::middleware('role:especialista')->prefix('especialista')->group(function () {
        Route::get('consultas/proximas', [ConsultaController::class, 'proximas']);
        Route::get('pacientes', [EspecialistaController::class, 'misPacientes']);
        Route::get('pacientes/{id}/historial', [HistorialMedicoController::class, 'verPorPaciente']);
        Route::get('pacientes/{id}/documentos', [DocumentoController::class, 'documentosDePaciente']);
        Route::get('pacientes/{id}/bono', [BonosController::class, 'verificarBono']);
        Route::get('consultas/{id}/videollamada', [VideollamadaController::class, 'enlace']);
        Route::post('historial/{id}/entrada', [EntradaHistorialController::class, 'store']);
        Route::put('consultas/{id}/realizar', [ConsultaController::class, 'marcarComoRealizada']);
        Route::post('pacientes/{id}/documentos', [DocumentoController::class, 'subir']);
        Route::get('estadisticas', [EspecialistaController::class, 'estadisticas']);
    });

    // Rutas para pacientes
    Route::middleware('role:paciente')->prefix('paciente')->group(function () {
        Route::get('consultas', [ConsultaController::class, 'misConsultas']);
        Route::post('consultas/inicial', [ConsultaController::class, 'solicitarInicial']);
        Route::get('historial', [HistorialMedicoController::class, 'mio']);
        Route::get('documentos', [DocumentoController::class, 'misDocumentos']);
        Route::post('documentos', [DocumentoController::class, 'subir']);
        Route::delete('documentos/{id}', [DocumentoController::class, 'eliminar']);
        Route::get('bono', [BonosController::class, 'miBono']);
        Route::post('bono/comprar', [BonosController::class, 'comprar']);
        Route::get('perfil', [UsuarioController::class, 'miPerfil']);
        Route::put('perfil', [UsuarioController::class, 'actualizarPerfil']);
        Route::get('consultas/{id}/videollamada', [VideollamadaController::class, 'enlace']);
        Route::patch('consultas/{id}/cancelar', [ConsultaController::class, 'cancelar']);
    });
});

// Rutas para recursos con soft deletes
Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('pacientes')->group(function () {
        Route::post('{id}/restore', [PacienteController::class, 'restore']);
        Route::get('trashed', [PacienteController::class, 'indexEliminados']);
        Route::get('{id}/consultas', [PacienteController::class, 'consultas']);
    });

    Route::prefix('especialistas')->group(function () {
        Route::post('{id}/restore', [EspecialistaController::class, 'restore']);
        Route::get('trashed', [EspecialistaController::class, 'indexEliminados']);
    });
});

// Rutas específicas para consultas
Route::middleware('auth:sanctum')->prefix('consultas')->group(function () {
    Route::post('{id}/pagar', [ConsultaController::class, 'pagar']);
    Route::patch('{id}/cancelar', [ConsultaController::class, 'cancelar']);
    Route::get('{id}/videollamada', [ConsultaController::class, 'videollamada']);
});

// Rutas de logs (autenticación con token API, distinto a sanctum)
Route::middleware('auth:api')->group(function () {
    Route::resource('logs', LogController::class)->only(['index', 'store', 'show', 'destroy']);
});

// Ruta para obtener usuario autenticado
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
