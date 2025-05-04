<?php

namespace App\Providers;

use App\Models\Paciente;
use App\Models\Usuario;
use App\Models\Especialista;
use App\Policies\PacientePolicy;
use App\Policies\UsuarioPolicy;
use App\Policies\EspecialistaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * El mapeo de políticas para la aplicación.
     *
     * @var array
     */
    protected $policies = [
        // Mapeo de políticas a modelos
        Paciente::class => PacientePolicy::class,
        Usuario::class => UsuarioPolicy::class,
        Especialista::class => EspecialistaPolicy::class,
    ];

    /**
     * Registra cualquier servicio de autorización.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Puedes agregar más Gates si es necesario
    }
}
