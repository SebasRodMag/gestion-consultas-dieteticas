<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DocumentoController extends Controller
{
    public function misDocumentos()
{
    $historial = auth()->user()->paciente->historialMedico;

    return response()->json($historial->documentos);
}

public function subir(Request $request)
{
    // Validación y almacenamiento de documento
    $validated = $request->validate([
        'documento' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
    ]); 
}

public function eliminar($id)
{
    // Verificar que el documento pertenece al paciente antes de eliminar
    $documento = Documento::findOrFail($id);
    if ($documento->paciente_id !== auth()->user()->paciente->id) {
        return response()->json(['message' => 'No autorizado'], 403);
    }
    
}
}
