<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'paciente']);
        Role::create(['name' => 'especialista']);
        Role::create(['name' => 'usuario']);
        Role::create(['name' => 'admin']);
    }
}
