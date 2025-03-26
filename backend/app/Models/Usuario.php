<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'USUARIOS';
    protected $primaryKey = 'id_usuario';
    public $timestamps = false; //Se desactiva el timestamps automáticos de Laravel

    //Se definir los nombres de las columnas de fecha
    const CREATED_AT = 'fecha_creacion';
    const UPDATED_AT = 'fecha_actualizacion';

    //relaciones:

    public function especialista()
    {
        return $this->hasOne(Especialista::class, 'id_usuario');
    }

    public function paciente()
    {
        return $this->hasOne(Paciente::class, 'id_usuario');
    }
}
