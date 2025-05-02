<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bono extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bonos';

    protected $fillable = [
        'id_paciente', 'total_consultas', 'consultas_utilizadas', 'fecha_compra', 'fecha_expiracion'
    ];

    // Relación inversa con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
