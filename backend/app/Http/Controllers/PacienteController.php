<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;

class PacienteController extends Controller
{
    // Crear un nuevo paciente
    public function store(Request $request)
    {
        $this->authorize('create', Paciente::class);

        if (Paciente::where('id_usuario', $request->id_usuario)->exists()) {
            return response()->json(['message' => 'Este usuario ya es paciente'], 409);
        }

        $validated = $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'fecha_alta' => 'required|date',
        ]);

        $paciente = Paciente::create($validated);

        LogHelper::guardar(auth()->user(), 'Paciente creado', $paciente);

        return response()->json($paciente, 201);
    }

    // Listar todos los pacientes (activos y eliminados)
    public function index()
    {
        $this->authorize('viewAny', Paciente::class);

        $pacientes = Paciente::withTrashed()->paginate(10);
        return response()->json($pacientes);
    }

    // Listar solo pacientes eliminados
    public function indexEliminados()
    {
        $this->authorize('viewAny', Paciente::class);

        $pacientes = Paciente::onlyTrashed()->paginate(10);
        return response()->json($pacientes);
    }

    // Listar solo pacientes activos
    public function indexActivos()
    {
        $this->authorize('viewAny', Paciente::class);

        $pacientes = Paciente::withoutTrashed()->paginate(10);
        return response()->json($pacientes);
    }

    // Mostrar un paciente específico
    public function show($id)
    {
        $paciente = Paciente::withTrashed()->findOrFail($id);

        $this->authorize('view', $paciente);

        return response()->json($paciente);
    }

    // Mostrar las consultas del paciente
    public function consultas($id)
    {
        $paciente = Paciente::findOrFail($id);

        $this->authorize('view', $paciente);

        return response()->json($paciente->consultas);
    }

    // Actualizar paciente
    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);

        $this->authorize('update', $paciente);

        $validated = $request->validate([
            'fecha_alta' => 'sometimes|date',
            // Añade más validaciones si corresponde
        ]);

        $paciente->update($validated);

        LogHelper::guardar(auth()->user(), 'Paciente actualizado', $paciente);

        return response()->json($paciente);
    }

    // Eliminar (soft delete) paciente
    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);

        $this->authorize('delete', $paciente);

        $paciente->delete();

        LogHelper::guardar(auth()->user(), 'Paciente eliminado', $paciente);

        return response()->json(['message' => 'Paciente eliminado']);
    }

    // Restaurar paciente eliminado
    public function restore($id)
    {
        $paciente = Paciente::withTrashed()->findOrFail($id);

        $this->authorize('restore', $paciente);

        $paciente->restore();

        LogHelper::guardar(auth()->user(), 'Paciente restaurado', $paciente);

        return response()->json(['message' => 'Paciente restaurado']);
    }

    // Eliminar permanentemente paciente
    public function forceDelete($id)
    {
        $paciente = Paciente::withTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $paciente);

        $paciente->forceDelete();

        LogHelper::guardar(auth()->user(), 'Paciente eliminado permanentemente', $paciente);

        return response()->json(['message' => 'Paciente eliminado permanentemente']);
    }

    public function estaActivo()
    {
        return is_null($this->fecha_baja) && is_null($this->deleted_at);
    }
}
