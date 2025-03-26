<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Documentos extends Model
{
    use HasFactory;

    protected $table = 'DOCUMENTOS';
    protected $primaryKey = 'id_documento';
    public $timestamps = false; //Se desactiva el timestamps automáticos de Laravel


    //Se define la relación con HistorialMedico
    public function historialMedico(){
        return $this->belongsTo(HistorialMedico::class, 'id_historial');
    }

}