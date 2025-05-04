<?php

namespace App\Http\Controllers;

use App\Models\Especialista;
use App\Models\Log;
use Illuminate\Http\Request;

class EspecialistaController extends Controller
{
    // Crear un nuevo especialista
    public function store(Request $request)
    {
        $this->authorize('create', Especialista::class);

        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'especialidad' => 'required|string',
        ]);

        $especialista = Especialista::create($request->only(['id_usuario', 'especialidad']));

        Log::create([
            'usuario_id' => auth()->id(),
            'accion' => 'Crear especialista',
            'detalles' => "Especialista ID: {$especialista->id} - Especialidad: {$especialista->especialidad}"
        ]);

        return response()->json($especialista, 201);
    }

    // Obtener todos los especialistas (paginado, incluso eliminados)
    public function index()
    {
        $this->authorize('viewAny', Especialista::class);

        $especialistas = Especialista::withTrashed()->paginate(10);
        return response()->json($especialistas);
    }

    // Obtener todos los especialistas eliminados
    public function indexEliminados()
    {
        $this->authorize('viewAny', Especialista::class);

        $especialistas = Especialista::onlyTrashed()->paginate(10);
        return response()->json($especialistas);
    }

    // Obtener todos los especialistas activos
    public function indexActivos()
    {
        $this->authorize('viewAny', Especialista::class);

        $especialistas = Especialista::whereNull('deleted_at')->paginate(10);
        return response()->json($especialistas);
    }

    // Obtener un especialista específico
    public function show($id)
    {
        $especialista = Especialista::withTrashed()->findOrFail($id);
        $this->authorize('view', $especialista);

        return response()->json($especialista);
    }

    // Actualizar un especialista
    public function update(Request $request, $id)
    {
        $especialista = Especialista::withTrashed()->findOrFail($id);
        $this->authorize('update', $especialista);

        // Evitar que se actualicen especialistas eliminados
        if ($especialista->trashed()) {
            return response()->json(['message' => 'Especialista eliminado, no se puede actualizar'], 400);
        }

        $request->validate([
            'especialidad' => 'sometimes|required|string',
        ]);

        $especialista->update($request->only(['especialidad']));

        Log::create([
            'usuario_id' => auth()->id(),
            'accion' => 'Actualizar especialista',
            'detalles' => "Especialista ID: {$especialista->id} - Especialidad actualizada a: {$especialista->especialidad}"
        ]);

        return response()->json($especialista);
    }

    // Eliminar un especialista (soft delete)
    public function destroy($id)
    {
        $especialista = Especialista::findOrFail($id);
        $this->authorize('delete', $especialista);

        // Eliminar solo si el especialista no está ya eliminado
        if ($especialista->trashed()) {
            return response()->json(['message' => 'Este especialista ya está eliminado'], 400);
        }

        $especialista->delete();

        Log::create([
            'usuario_id' => auth()->id(),
            'accion' => 'Eliminar especialista',
            'detalles' => "Especialista ID: {$especialista->id} - Especialidad: {$especialista->especialidad}"
        ]);

        return response()->json(['message' => 'Especialista eliminado']);
    }

    // Restaurar un especialista eliminado
    public function restore($id)
    {
        $especialista = Especialista::withTrashed()->findOrFail($id);
        $this->authorize('restore', $especialista);

        $especialista->restore();

        Log::create([
            'usuario_id' => auth()->id(),
            'accion' => 'Restaurar especialista',
            'detalles' => "Especialista ID: {$especialista->id} - Especialidad restaurada: {$especialista->especialidad}"
        ]);

        return response()->json(['message' => 'Especialista restaurado']);
    }
}

