<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BonoController extends Controller
{
    public function miBono()
{
    return response()->json(auth()->user()->paciente->bono);
}

public function comprar()
{
    // Registrar compra de bono (crear o actualizar el bono)
}
}
