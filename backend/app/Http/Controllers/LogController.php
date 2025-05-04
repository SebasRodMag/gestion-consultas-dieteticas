<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    // Mostrar todos los logs
    public function index()
    {
        $logs = Log::all();
        return response()->json($logs);
    }

    // Crear un nuevo log
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id_usuario',
            'accion' => 'required|string|max:255',
            'tabla_afectada' => 'nullable|string|max:255',
            'id_registro_afectado' => 'nullable|integer',
            'descripcion' => 'nullable|string',
        ]);

        $log = Log::create($request->all());

        return response()->json($log, 201);
    }

    // Ver un log específico
    public function show($id)
    {
        $log = Log::findOrFail($id);
        return response()->json($log);
    }

    // Eliminar un log
    public function destroy($id)
    {
        $log = Log::findOrFail($id);
        $log->delete();
        return response()->json(['message' => 'Log eliminado con éxito']);
    }
}
