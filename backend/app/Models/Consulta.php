<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $table = 'consultas';

    protected $fillable = [
        'id_paciente', 'id_especialista', 'tipo_consulta', 'fecha_hora_consulta', 'estado', 'comentario', 'pagada', 'tipo_pago'
    ];

    // Relación inversa con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    // Relación inversa con Especialista
    public function especialista()
    {
        return $this->belongsTo(Especialista::class, 'id_especialista');
    }

    // Relación uno a muchos con Pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_consulta');
    }
}
