<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre', 'apellidos', 'dni_usuario', 'email', 'fecha_nacimiento', 'telefono', 'rol', 'fecha_creacion', 'fecha_actualizacion'
    ];

    // Relación uno a uno con Paciente
    public function paciente()
    {
        return $this->hasOne(Paciente::class, 'id_usuario');
    }

    // Relación uno a uno con Especialista
    public function especialista()
    {
        return $this->hasOne(Especialista::class, 'id_usuario');
    }

    // Relación muchos a muchos con Consultas
    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'id_paciente');
    }
}
