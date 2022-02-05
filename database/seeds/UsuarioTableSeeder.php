<?php

use Illuminate\Database\Seeder;
use \Spatie\Permission\Models\Role;

class UsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name' => 'Administrador']);
        Role::create(['name' => 'Aspirante']);
        Role::create(['name' => 'Subsadanor']);
        Role::create(['name' => 'Curador']);
    }
}
