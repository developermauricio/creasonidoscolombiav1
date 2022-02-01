<?php

use App\Models\Aspirant;
use App\Models\AspirantType;
use App\Models\DocumentType;
use App\Models\Gender;
use App\Models\Zonas;
use App\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        // $this->call(UserSeeder::class);
        // zonas de colombia
        factory(Zonas::class, 10)->create();

        // ciudades y departamentos
        $path = 'database/seeds/sql/departamentos.sql';
        DB::unprepared(file_get_contents($path));
        $path = 'database/seeds/sql/ciudades.sql';
        DB::unprepared(file_get_contents($path));

        // generos
        factory(Gender::class, 1)->create([
            'name' => 'Masculino'
        ]);
        factory(Gender::class, 1)->create([
            'name' => 'Femenino'
        ]);
        factory(Gender::class, 1)->create([
            'name' => 'Otro'
        ]);

        // Tipo de documentos
        factory(DocumentType::class, 1)->create([
            'name' => 'CC'
        ]);
        factory(DocumentType::class, 1)->create([
            'name' => 'TI'
        ]);
        factory(DocumentType::class, 1)->create([
            'name' => 'CE'
        ]);

        factory(User::class, 30)->create();

        // tipos de aspirantes
        factory(AspirantType::class, 1)->create([
            'name' => 'Persona natural'
        ]);
        factory(AspirantType::class, 1)->create([
            'name' => 'Grupo Constituido'
        ]);


        // aspiranntes
        factory(Aspirant::class, 10)->create();
    }
}
