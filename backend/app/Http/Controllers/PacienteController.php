<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use App\Models\Consulta;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    // Crear un nuevo paciente
    public function store(Request $request)
    {
        $request->validate([
            'id_usuario' => 'required|exists:usuarios,id',
            'fecha_alta' => 'required|date',
        ]);

        $paciente = Paciente::create($request->all());

        return response()->json($paciente, 201);
    }

    // Obtener todos los pacientes (Incluso los eliminados)
    public function index()
    {
        $pacientes = Paciente::all();
        return response()->json($pacientes);
    }

    // Obtener todos los pacientes eliminados
    public function indexEliminados()
    {
        $pacientes = Paciente::onlyTrashed()->get();
        return response()->json($pacientes);
    }

    // Obtener todos los pacientes activos
    public function indexActivos()
    {
        $pacientes = Paciente::withTrashed()->get();
        return response()->json($pacientes);
    }

    // Obtener un paciente específico
    public function show($id)
    {
        $paciente = Paciente::findOrFail($id);
        return response()->json($paciente);
    }

    // Obtener las consultas de un paciente
    public function consultas($id)
    {
        $paciente = Paciente::findOrFail($id);
        $consultas = $paciente->consultas;
        return response()->json($consultas);
    }

    // Actualizar un paciente
    public function update(Request $request, $id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->update($request->all());

        return response()->json($paciente);
    }

    // Eliminar un paciente
    public function destroy($id)
    {
        $paciente = Paciente::findOrFail($id);
        $paciente->delete();

        return response()->json(['message' => 'Paciente eliminado']);
    }

    // Restaurar un paciente eliminado
    public function restore($id)
    {
        $paciente = Paciente::withTrashed()->findOrFail($id);
        $paciente->restore();

        return response()->json(['message' => 'Paciente restaurado']);
    }
}
