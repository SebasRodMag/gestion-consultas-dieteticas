<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Crear roles
        Role::create(['name' => 'administrador']);
        Role::create(['name' => 'especialista']);
        Role::create(['name' => 'paciente']);

        // Crear permisos
        Permission::create(['name' => 'ver pacientes']);
        Permission::create(['name' => 'editar pacientes']);

        // Asignar permisos a roles
        $admin = Role::findByName('administrador');
        $admin->givePermissionTo(['ver pacientes', 'editar pacientes']);

        $especialista = Role::findByName('especialista');
        $especialista->givePermissionTo('ver pacientes');
    }
}
