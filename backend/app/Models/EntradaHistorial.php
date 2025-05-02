<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntradaHistorial extends Model
{
    use HasFactory;

    protected $table = 'entradas_historial';

    protected $fillable = [
        'id_historial', 'id_consulta', 'descripcion', 'fecha_entrada'
    ];

    // Relación inversa con Historial Médico
    public function historial()
    {
        return $this->belongsTo(HistorialMedico::class, 'id_historial');
    }

    // Relación inversa con Consulta
    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'id_consulta');
    }
}
