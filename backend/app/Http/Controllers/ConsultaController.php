<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Pago;
use App\Models\Log;
use Illuminate\Http\Request;

class ConsultaController extends Controller
{
    // Crear una nueva consulta
    public function store(Request $request)
    {
        $request->validate([
            'id_paciente' => 'required|exists:pacientes,id',
            'id_especialista' => 'required|exists:especialistas,id',
            'tipo_consulta' => 'required|string',
            'fecha_hora_consulta' => 'required|date',
            'estado' => 'required|string',
        ]);

        $consulta = Consulta::create($request->all());

        Log::create([
            'id_usuario' => auth()->id(),
            'accion' => 'Crear',
            'tabla_afectada' => 'consultas',
            'id_registro_afectado' => $consulta->id,
            'descripcion' => 'Se creó una nueva consulta.',
        ]);

        return response()->json($consulta, 201);
    }

    // Listar todas las consultas (paginadas)
    public function index()
    {
        $consultas = Consulta::withTrashed()->paginate(10);
        return response()->json($consultas);
    }

    // Mostrar una consulta específica
    public function show($id)
    {
        $consulta = Consulta::withTrashed()->findOrFail($id);
        return response()->json($consulta);
    }

    // Actualizar una consulta
    public function update(Request $request, $id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->update($request->all());

        Log::create([
            'id_usuario' => auth()->id(),
            'accion' => 'Actualizar',
            'tabla_afectada' => 'consultas',
            'id_registro_afectado' => $consulta->id,
            'descripcion' => 'Consulta actualizada.',
        ]);

        return response()->json($consulta);
    }

    // Eliminar una consulta (soft delete)
    public function destroy($id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->delete();

        Log::create([
            'id_usuario' => auth()->id(),
            'accion' => 'Eliminar',
            'tabla_afectada' => 'consultas',
            'id_registro_afectado' => $consulta->id,
            'descripcion' => 'Consulta eliminada.',
        ]);

        return response()->json(['message' => 'Consulta eliminada']);
    }

    // Restaurar una consulta eliminada
    public function restore($id)
    {
        $consulta = Consulta::withTrashed()->findOrFail($id);
        $consulta->restore();

        Log::create([
            'id_usuario' => auth()->id(),
            'accion' => 'Restaurar',
            'tabla_afectada' => 'consultas',
            'id_registro_afectado' => $consulta->id,
            'descripcion' => 'Consulta restaurada.',
        ]);

        return response()->json(['message' => 'Consulta restaurada']);
    }

    // Solicitar consulta inicial (solo si no tiene otra activa)
    public function solicitarInicial(Request $request)
    {
        $paciente = auth()->user()->paciente;

        if (!$paciente) {
            return response()->json(['message' => 'No eres un paciente'], 403);
        }

        $consultaExistente = Consulta::where('id_paciente', $paciente->id)
            ->where('estado', '!=', 'cancelada')
            ->first();

        if ($consultaExistente) {
            return response()->json(['message' => 'Ya tienes una consulta pendiente o realizada'], 400);
        }

        $request->validate([
            'id_especialista' => 'required|exists:especialistas,id',
            'fecha_hora_consulta' => 'required|date',
        ]);

        $consulta = Consulta::create([
            'id_paciente' => $paciente->id,
            'id_especialista' => $request->id_especialista,
            'tipo_consulta' => 'inicial',
            'fecha_hora_consulta' => $request->fecha_hora_consulta,
            'estado' => 'pendiente',
        ]);

        Log::create([
            'id_usuario' => auth()->id(),
            'accion' => 'Crear',
            'tabla_afectada' => 'consultas',
            'id_registro_afectado' => $consulta->id,
            'descripcion' => 'Paciente solicitó consulta inicial.',
        ]);

        return response()->json($consulta, 201);
    }

    // Obtener mis consultas (paciente)
    public function misConsultas()
    {
        $paciente = auth()->user()->paciente;

        if (!$paciente) {
            return response()->json(['message' => 'No eres un paciente'], 403);
        }

        $consultas = $paciente->consultas()
            ->with('especialista.usuario')
            ->orderBy('fecha_hora_consulta', 'desc')
            ->paginate(10);

        return response()->json($consultas);
    }

    // Cancelar consulta
    public function cancelar($id)
    {
        $consulta = Consulta::findOrFail($id);

        if (in_array($consulta->estado, ['cancelada', 'realizada'])) {
            return response()->json(['message' => 'Consulta ya procesada'], 400);
        }

        $consulta->estado = 'cancelada';
        $consulta->save();

        Log::create([
            'id_usuario' => auth()->id(),
            'accion' => 'Actualizar',
            'tabla_afectada' => 'consultas',
            'id_registro_afectado' => $consulta->id,
            'descripcion' => 'Consulta cancelada.',
        ]);

        return response()->json(['message' => 'Consulta cancelada con éxito']);
    }

    // Marcar consulta como realizada (solo especialista asignado)
    public function marcarComoRealizada($id)
    {
        $consulta = Consulta::findOrFail($id);
        $especialista = auth()->user()->especialista;

        if (!$especialista || $consulta->id_especialista !== $especialista->id) {
            return response()->json(['message' => 'No autorizado'], 403);
        }

        if ($consulta->estado === 'cancelada') {
            return response()->json(['message' => 'No se puede marcar como realizada una consulta cancelada'], 400);
        }

        $consulta->estado = 'realizada';
        $consulta->save();

        Log::create([
            'id_usuario' => auth()->id(),
            'accion' => 'Actualizar',
            'tabla_afectada' => 'consultas',
            'id_registro_afectado' => $consulta->id,
            'descripcion' => 'Consulta marcada como realizada.',
        ]);

        return response()->json(['message' => 'Consulta marcada como realizada']);
    }

    // Enlace videollamada
    public function enlaceVideollamada($id)
    {
        $consulta = Consulta::findOrFail($id);

        return response()->json([
            'link' => $consulta->link_videollamada,
        ]);
    }

    // Pagar una consulta
    public function pagar(Request $request, $id)
    {
        $request->validate([
            'metodo_pago' => 'required|string',
            'cantidad' => 'required|numeric',
        ]);

        $consulta = Consulta::findOrFail($id);

        $pago = Pago::create([
            'id_consulta' => $consulta->id,
            'cantidad' => $request->cantidad,
            'metodo_pago' => $request->metodo_pago,
            'estado_pago' => 'realizado',
            'fecha_pago' => now(),
        ]);

        Log::create([
            'id_usuario' => auth()->id(),
            'accion' => 'Crear',
            'tabla_afectada' => 'pagos',
            'id_registro_afectado' => $pago->id,
            'descripcion' => 'Pago registrado para consulta ID ' . $consulta->id,
        ]);

        return response()->json($pago, 201);
    }
}
