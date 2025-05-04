<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Paciente;
use Illuminate\Auth\Access\HandlesAuthorization;

class PacientePolicy
{
    use HandlesAuthorization;

    /**
     * Determina si el usuario puede ver cualquier paciente.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function viewAny(User $user)
    {
        // El administrador o especialista pueden ver pacientes
        return $user->hasRole('administrador') || $user->hasRole('especialista');
    }

    /**
     * Determina si el usuario puede ver un paciente específico.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paciente  $paciente
     * @return bool
     */
    public function view(User $user, Paciente $paciente)
    {
        // El administrador o especialista pueden ver pacientes
        // El propio paciente puede ver su propia información
        return $user->hasRole('administrador') || $user->hasRole('especialista') || $user->id === $paciente->id_usuario;
    }

    /**
     * Determina si el usuario puede crear un nuevo paciente.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function create(User $user)
    {
        // Solo administradores pueden crear pacientes
        return $user->hasRole('administrador');
    }

    /**
     * Determina si el usuario puede actualizar un paciente.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paciente  $paciente
     * @return bool
     */
    public function update(User $user, Paciente $paciente)
    {
        // El administrador o especialista pueden actualizar pacientes
        return $user->hasRole('administrador') || ($user->hasRole('especialista') && $user->id === $paciente->id_usuario);
    }

    /**
     * Determina si el usuario puede eliminar un paciente.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paciente  $paciente
     * @return bool
     */
    public function delete(User $user, Paciente $paciente)
    {
        // Solo el administrador o el propio paciente pueden eliminar el paciente
        return $user->hasRole('administrador') || ($user->id === $paciente->id_usuario);
    }

    /**
     * Determina si el usuario puede restaurar un paciente eliminado.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Paciente  $paciente
     * @return bool
     */
    public function restore(User $user, Paciente $paciente)
    {
        // El administrador puede restaurar pacientes eliminados
        return $user->hasRole('administrador');
    }
}
