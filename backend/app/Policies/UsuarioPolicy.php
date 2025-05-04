<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Usuario;

class UsuarioPolicy
{
    /**
     * Determina si el usuario puede ver la lista de usuarios.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('administrador');
    }

    /**
     * Determina si el usuario puede ver a un usuario específico.
     */
    public function view(User $user, Usuario $usuario): bool
    {
        return $user->hasRole('administrador') || $user->id === $usuario->id;
    }

    /**
     * Determina si el usuario puede crear nuevos usuarios.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('administrador');
    }

    /**
     * Determina si el usuario puede actualizar la información del usuario.
     */
    public function update(User $user, Usuario $usuario): bool
    {
        return $user->hasRole('administrador') || $user->id === $usuario->id;
    }

    /**
     * Determina si el usuario puede eliminar al usuario.
     */
    public function delete(User $user, Usuario $usuario): bool
    {
        return $user->hasRole('administrador') && $user->id !== $usuario->id;
    }

    /**
     * Determina si el usuario puede restaurar a un usuario eliminado.
     */
    public function restore(User $user, Usuario $usuario): bool
    {
        return $user->hasRole('administrador');
    }

    /**
     * Determina si el usuario puede eliminar permanentemente (force delete).
     */
    public function forceDelete(User $user, Usuario $usuario): bool
    {
        return $user->hasRole('administrador');
    }
}
