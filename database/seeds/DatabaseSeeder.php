<?php

namespace Database\Seeders;

use App\Models\Zonas;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
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
