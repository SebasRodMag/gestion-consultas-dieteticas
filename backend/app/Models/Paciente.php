<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'PACIENTE';
    protected $primaryKey = 'id_paciente';
    public $timestamps = false; //Se desactiva el timestamps automáticos de Laravel

    //Se define la relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    //Se define la relación con HistorialMedico
    public function historialMedico(){
        return $this->hasMany(HistorialMedico::class, 'id_paciente');
    }

    //Se define la relación con Consulta
    public function consulta(){
        return $this->hasMany(Consulta::class, 'id_paciente');
    }
}
