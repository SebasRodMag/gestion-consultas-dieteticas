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

    // Obtener todos los especialistas
    public function index()
    {
        $especialistas = Especialista::all();
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
}
