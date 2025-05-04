<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    // Definir la tabla si es diferente al plural del nombre del modelo
    protected $table = 'logs';

    // Los campos que pueden ser asignados masivamente
    protected $fillable = [
        'id_usuario',
        'accion',
        'descripcion',
        'tabla_afectada',
        'id_registro_afectado',
        'fecha_log'
    ];

    // Evitar que el modelo espere timestamps automáticamente si no los usas
    public $timestamps = false;
}
