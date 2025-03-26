<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Consulta extends Model
{
    use HasFactory;

    protected $table = 'CONSULTA';
    protected $primaryKey = 'id_consulta';
    public $timestamps = false; //Se desactiva el timestamps automáticos de Laravel

    //Se define la relación con Especialista
    public function especialista()
    {
        return $this->belongsTo(Especialista::class, 'id_especialista');
    }
    //Se define la relación con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }
}
