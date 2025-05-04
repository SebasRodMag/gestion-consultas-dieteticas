<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VideollamadaController extends Controller
{
    public function enlace($consultaId)
{
    $consulta = Consulta::where('id', $consultaId)
                        ->where('id_paciente', auth()->user()->paciente->id)
                        ->firstOrFail();

    return response()->json(['url' => $consulta->url_videollamada]);
}

}
