<?php

use App\Models\Zonas;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {
        // $this->call(UserSeeder::class);
        Zonas::factory(10)->create();
        $path = 'database/seeds/sql/departamentos.sql';
        DB::unprepared(file_get_contents($path));
        $path = 'database/seeds/sql/ciudades.sql';
        DB::unprepared(file_get_contents($path));
    }
}
