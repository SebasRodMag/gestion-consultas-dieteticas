<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Especialista extends Model
{
    use HasFactory;

    protected $table = 'ESPECIALISTA';
    protected $primaryKey = 'id_especialista';
    public $timestamps = false; //Se desactiva el timestamps automáticos de Laravel
    
    //Se define la relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    //Se define la relación con Consulta
    public function consulta(){
        return $this->hasMany(Consulta::class, 'id_especialista');
    }

    //Se acceder a fecha de creación y actualización a través de Usuario
    public function getFechaCreacion()
    {
        return $this->usuario->fecha_creacion;
    }

    public function getFechaActualizacion()
    {
        return $this->usuario->fecha_actualizacion;
    }

}
