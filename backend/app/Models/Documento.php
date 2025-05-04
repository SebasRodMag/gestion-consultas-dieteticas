<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Documento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'documentos';

    protected $fillable = [
        'id_historial',
        'nombre_archivo',
        'ruta_archivo',
        'fecha_hora_ultima_modificacion',
    ];

    // Relación inversa con Historial Médico
    public function historial()
    {
        return $this->belongsTo(HistorialMedico::class, 'id_historial');
    }
}
