<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\Pago;
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

        return response()->json($consulta, 201);
    }

    // Obtener todas las consultas
    public function index()
    {
        $consultas = Consulta::all();
        return response()->json($consultas);
    }

    // Obtener una consulta específica
    public function show($id)
    {
        $consulta = Consulta::findOrFail($id);
        return response()->json($consulta);
    }

    // Actualizar una consulta
    public function update(Request $request, $id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->update($request->all());

        return response()->json($consulta);
    }

    // Eliminar una consulta
    public function destroy($id)
    {
        $consulta = Consulta::findOrFail($id);
        $consulta->delete();

        return response()->json(['message' => 'Consulta eliminada']);
    }

    // Realizar el pago de una consulta
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

        return response()->json($pago, 201);
    }

    public function cancelar($id)
{
    // Obtener la consulta por ID
    $consulta = Consulta::find($id);

    // Verificar si la consulta existe
    if (!$consulta) {
        return response()->json(['message' => 'Consulta no encontrada'], 404);
    }

    // Cambiar el estado de la consulta a 'cancelada'
    $consulta->estado = 'cancelada';
    $consulta->save();

    return response()->json(['message' => 'Consulta cancelada con éxito'], 200);
}

public function videollamada($id)
{
    // Obtener la consulta por ID
    $consulta = Consulta::find($id);

    // Verificar si la consulta existe
    if (!$consulta) {
        return response()->json(['message' => 'Consulta no encontrada'], 404);
    }

    // Obtener el enlace de la videollamada (esto puede estar relacionado con una API como Jitsi)
    $linkVideollamada = $consulta->link_videollamada;

    return response()->json(['link' => $linkVideollamada], 200);
}
}
