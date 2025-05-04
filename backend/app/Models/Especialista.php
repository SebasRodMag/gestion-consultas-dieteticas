<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Especialista extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'especialistas';

    protected $fillable = [
        'id_usuario', 'especialidad'
    ];

    // Relación uno a uno con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    // Relación uno a muchos con Consultas
    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'id_especialista');
    }
}
