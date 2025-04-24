<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $table = 'pagos';

    protected $fillable = [
        'id_paciente', 'id_consulta', 'id_bono', 'cantidad', 'metodo_pago', 'estado_pago', 'fecha_pago'
    ];

    // Relación inversa con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    // Relación inversa con Consulta
    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'id_consulta');
    }

    // Relación inversa con Bono
    public function bono()
    {
        return $this->belongsTo(Bono::class, 'id_bono');
    }
}
