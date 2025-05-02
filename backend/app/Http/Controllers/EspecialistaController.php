<?php

namespace App\Http\Controllers;

use App\Models\Especialista;
use Illuminate\Http\Request;

class EspecialistaController extends Controller
{
    // Crear un nuevo especialista
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'especialidad' => 'required|string',
        ]);

        $especialista = Especialista::create($request->all());

        return response()->json($especialista, 201);
    }

    // Obtener todos los especialistas (Incluso los eliminados)
    public function index()
    {
        $especialistas = Especialista::all();
        return response()->json($especialistas);
    }

    // Obtener todos los especialistas eliminados
    public function indexEliminados()
    {
        $especialistas = Especialista::onlyTrashed()->get();
        return response()->json($especialistas);
    }

    // Obtener todos los especialistas activos
    public function indexActivos()
    {
        $especialistas = Especialista::withTrashed()->get();
        return response()->json($especialistas);
    }

    // Obtener un especialista específico
    public function show($id)
    {
        $especialista = Especialista::findOrFail($id);
        return response()->json($especialista);
    }

    // Actualizar un especialista
    public function update(Request $request, $id)
    {
        $especialista = Especialista::findOrFail($id);
        $especialista->update($request->all());

        return response()->json($especialista);
    }

    // Eliminar un especialista
    public function destroy($id)
    {
        $especialista = Especialista::findOrFail($id);
        $especialista->delete();

        return response()->json(['message' => 'Especialista eliminado']);
    }

    // Restaurar un especialista eliminado
    public function restore($id)
    {
        $especialista = Especialista::withTrashed()->findOrFail($id);
        $especialista->restore();

        return response()->json(['message' => 'Especialista restaurado']);
    }

    
}
