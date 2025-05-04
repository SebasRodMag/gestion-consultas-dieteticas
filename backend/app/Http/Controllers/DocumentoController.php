<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentoController extends Controller
{
    public function misDocumentos()
    {
        $historial = auth()->user()->paciente->historialMedico;

        return response()->json($historial->documentos);
    }

    public function subir(Request $request)
    {
        $validated = $request->validate([
            'archivo' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $user = auth()->user();
        $historial = $user->paciente->historialMedico;

        $file = $request->file('archivo');
        $path = $file->store('documentos', 'public');

        Documento::create([
            'id_historial' => $historial->id_historial,
            'nombre_archivo' => $file->getClientOriginalName(),
            'ruta_archivo' => $path,
            'fecha_hora_ultima_modificacion' => now(),
        ]);

        return response()->json(['message' => 'Documento subido con éxito'], 201);
    }

    public function eliminar($id)
    {
        $documento = Documento::findOrFail($id);
        $historial = auth()->user()->paciente->historialMedico;

        // Comprobar que el documento pertenece al paciente autenticado
        if ($documento->id_historial !== $historial->id_historial) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        // Eliminar el archivo físico (si existe)
        if (Storage::disk('public')->exists($documento->ruta_archivo)) {
            Storage::disk('public')->delete($documento->ruta_archivo);
        }

        $documento->delete(); // soft delete

        return response()->json(['message' => 'Documento eliminado correctamente'], 200);
    }
}
