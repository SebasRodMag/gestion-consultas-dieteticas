<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $table = 'paciente';

    protected $fillable = [
        'id_usuario', 'fecha_alta', 'fecha_baja'
    ];

    // Relación uno a uno con Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    // Relación uno a muchos con Consultas
    public function consultas()
    {
        return $this->hasMany(Consulta::class, 'id_paciente');
    }

    // Relación uno a muchos con Pagos
    public function pagos()
    {
        return $this->hasMany(Pago::class, 'id_paciente');
    }

    // Relación uno a muchos con Bonos
    public function bonos()
    {
        return $this->hasMany(Bono::class, 'id_paciente');
    }

    // Relación uno a uno con Historial Médico
    public function historial()
    {
        return $this->hasOne(HistorialMedico::class, 'id_paciente');
    }
}
