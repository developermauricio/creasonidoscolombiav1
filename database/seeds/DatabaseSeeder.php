<?php

use App\Models\Aspirant;
use App\Models\AspirantType;
use App\Models\DocumentType;
use App\Models\Gender;
use App\Models\Zonas;
use App\User;
use  \Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends \Illuminate\Database\Seeder
{
    public function run()
    {


        Storage::deleteDirectory('aspirant');
        Storage::deleteDirectory('projects');
        Storage::deleteDirectory('archives');
        Storage::makeDirectory('users');
        Storage::makeDirectory('projects');
        Storage::makeDirectory('archives');

        $this->call(UsuarioTableSeeder::class);
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


        // tipos de aspirantes
        factory(AspirantType::class, 1)->create([
            'name' => 'Persona natural'
        ]);
        factory(AspirantType::class, 1)->create([
            'name' => 'Grupo Constituido'
        ]);

        /*=============================================
           CREANDO TIPOS DE CALIFICACIONES
        =============================================*/
        factory(\App\Models\Qualification::class)->create(['name' => 'Calidad interpretativa', 'description' => 'Comunicación, proyección, dicción.', 'value' => 20]);
        factory(\App\Models\Qualification::class)->create(['name' => 'Calidad musical de la propuesta', 'description' => 'Aspectos técnicos musicales, afinación, ritmo, fraseo, tiempo, dinámica, equilibrio sonoro, dicción y articulación.', 'value' => 20]);
        factory(\App\Models\Qualification::class)->create(['name' => 'Calidad de composición', 'description' => 'Aporte creativo, realización vocal e instrumental, originalidad, y fidelidad a las formas y estilos tradicionales, cuando sea aplicable al contexto.', 'value' => 20]);
        factory(\App\Models\Qualification::class)->create(['name' => 'Potencial de la canción', 'description' => 'Calidad del repertorio escogido, selección de la obra con relación a la diversidad de ritmos, tonalidades y formas.', 'value' => 20]);
        factory(\App\Models\Qualification::class)->create(['name' => 'Valor patrimonial y territorial', 'description' => 'Se tendrá en cuenta la importancia de la música de autor nacional y que sea de las músicas raizales, la tradición oral, y las músicas autóctonas y locales en el territorio.', 'value' => 20]);

        /*=============================================
           CREANDO TIPOS DE INDENTIFICACIÓN
        =============================================*/
        factory(\App\Models\Category::class)->create(['category' => 'Músicas populares y campesinas', 'slug' => \Illuminate\Support\Str::slug('Músicas populares y campesinas', '-')]);
        factory(\App\Models\Category::class)->create(['category' => 'Música tradicional y patrimonial', 'slug' => \Illuminate\Support\Str::slug('Música tradicional y patrimonial', '-')]);
        factory(\App\Models\Category::class)->create(['category' => 'Música patrimonial fusión', 'slug' => \Illuminate\Support\Str::slug('Música patrimonial fusión', '-')]);
        factory(\App\Models\Category::class)->create(['category' => 'Música bailable', 'slug' => \Illuminate\Support\Str::slug('Música bailable', '-')]);
        factory(\App\Models\Category::class)->create(['category' => 'Música urbana', 'slug' => \Illuminate\Support\Str::slug('Música urbana', '-')]);
        factory(\App\Models\Category::class)->create(['category' => 'Músicas espirituales y religiosas', 'slug' => \Illuminate\Support\Str::slug('Músicas espirituales y religiosas', '-')]);
        factory(\App\Models\Category::class)->create(['category' => 'Música Clásica', 'slug' => \Illuminate\Support\Str::slug('Música Clásica', '-')]);
        factory(\App\Models\Category::class)->create(['category' => 'Otras Músicas', 'slug' => \Illuminate\Support\Str::slug('Otras Músicas', '-')]);

        /*=============================================
         CREAMOS EL ADMINISTRADOR DEL SISTEMA
       =============================================*/
        factory(User::class, 1)->create([
            'name' => 'Admin',
            'last_name' => 'Sistema',
            'email' => 'admin@admin.co',
        ])->each(function (\App\User $u) {
            $u->roles()->attach('1');
        });

        /*=============================================
         CREAMOS 100 ASPIRANTES CON PROYECTOS EN REVISION
       =============================================*/
        factory(User::class, 100)->create([
        ])->each(function (User $u) {
            $u->roles()->attach('2');
            factory(Aspirant::class, 1)
                ->create([
                    'has_project' => Aspirant::HAS_PROJECT,
                    'user_id' => $u->id,
                ])->each(function (Aspirant $as) {
                    factory(\App\Models\Proyect::class, 1)
                        ->create([
                            'state' => \App\Models\Proyect::REVISION
                        ])->each(function (\App\Models\Proyect $proyect) use ($as) {
                            $proyect->aspirant()->attach($as->id);
                        });
                });
        });

        /*=============================================
         CREAMOS 100 ASPIRANTES EN PROCESO DE CURADURIA
       =============================================*/
        factory(User::class, 100)->create([
        ])->each(function (User $u) {
            $u->roles()->attach('2');
            factory(Aspirant::class, 1)
                ->create([
                    'has_project' => Aspirant::HAS_PROJECT,
                    'user_id' => $u->id,
                ])->each(function (Aspirant $as) use ($u) {
                    factory(\App\Models\Proyect::class, 1)
                        ->create([
                            'state' => \App\Models\Proyect::ACEPTED,
                            'categories_id' => 1
                        ])->each(function (\App\Models\Proyect $proyect) use ($as, $u) {
                            $proyect->aspirant()->attach($as->id);
                        });
                });
        });

        /*=============================================
         CREAMOS 8 CURADORES
       =============================================*/
        for ($i = 1; $i < 9; $i++) {
            factory(User::class, 1)->create()
                ->each(function (User $u) use ($i) {
                    $u->roles()->attach('4');
                    factory(\App\Models\Curador::class, 1)
                        ->create([
                            'user_id' => $u->id,
                            'categories_id' => $i
                        ])->each(function (\App\Models\Curador $curador){
                            for ($i = 1; $i < 21; $i++) {
                                $curador->projects()->attach(\App\Models\Proyect::all()->random()->id);
                            }
                        });

                });
        }

    }
}
