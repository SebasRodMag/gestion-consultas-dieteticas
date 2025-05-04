<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Especialista;

class EspecialistaPolicy
{
    /**
     * Determina si el usuario puede ver la lista de especialistas.
     */
    public function viewAny(User $user)
    {
        return $user->rol === 'Administrador';
    }

    /**
     * Determina si el usuario puede ver un especialista específico.
     */
    public function view(User $user, Especialista $especialista)
    {
        return $user->rol === 'Administrador' || $user->id === $especialista->id_usuario;
    }

    /**
     * Determina si el usuario puede crear un nuevo especialista.
     */
    public function create(User $user)
    {
        return $user->rol === 'Administrador';
    }

    /**
     * Determina si el usuario puede actualizar un especialista.
     */
    public function update(User $user, Especialista $especialista)
    {
        return $user->rol === 'Administrador';
    }

    /**
     * Determina si el usuario puede eliminar un especialista.
     */
    public function delete(User $user, Especialista $especialista)
    {
        return $user->rol === 'Administrador';
    }

    /**
     * Determina si el usuario puede restaurar un especialista.
     */
    public function restore(User $user, Especialista $especialista)
    {
        return $user->rol === 'Administrador';
    }

    /**
     * Determina si el usuario puede eliminar permanentemente un especialista (no se usa en este proyecto).
     */
    public function forceDelete(User $user, Especialista $especialista)
    {
        return false;
    }
}
