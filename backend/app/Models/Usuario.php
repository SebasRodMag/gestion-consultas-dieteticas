<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;


class Usuario extends Model
{
    use HasFactory, HasRoles;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre', 'apellidos', 'email', 'dni_usuario', 'fecha_nacimiento', 'telefono', 'password', 'rol',
    ];
    protected $hidden = [
        'password',
        'remember_token',
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

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
