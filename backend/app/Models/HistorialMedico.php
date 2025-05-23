<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialMedico extends Model
{
    use HasFactory;

    protected $table = 'historial_medicos';

    protected $fillable = [
        'id_paciente', 'descripcion', 'fecha_hora_ultima_modificacion'
    ];

    // Relación inversa con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    // Relación uno a muchos con Entradas de historial
    public function entradas()
    {
        return $this->hasMany(EntradaHistorial::class, 'id_historial');
    }
}
