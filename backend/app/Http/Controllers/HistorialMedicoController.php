<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HistorialMedicoController extends Controller
{
    public function mio()
{
    $historial = auth()->user()->paciente->historialMedico;

    return response()->json($historial);
}
}