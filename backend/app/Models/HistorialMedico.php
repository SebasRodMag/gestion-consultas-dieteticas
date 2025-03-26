<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistorialMedico extends Model
{
    use HasFactory;

    protected $table = 'HISTORIAL_MEDICO';
    protected $primaryKey = 'id_historial';
    public $timestamps = false; //Se desactiva el timestamps automáticos de Laravel

    //Se define la relación con Paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'id_paciente');
    }

    //Se define la relación con Documento
    public function documentos(){
        return $this->hasMany(Documentos::class, 'id_historial');
    }

}