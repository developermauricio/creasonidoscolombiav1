<?php

namespace App\Console\Commands;

use App\Models\Aspirant;
use App\Models\AspirantProyect;
use Illuminate\Console\Command;
use App\Models\ReportVariable;
use App\Services\GoogleSheet;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class RegisterAspirant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:registeredAspirant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando permite poder sincronizar los datos de los usuarios registrados';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle( GoogleSheet $googleSheet )
    {
        $variable = ReportVariable::query()
            ->where('name', 'lastRegisteredIDSync')
            ->first();

        //Log::debug('Comando...');
        //Log::debug($variable->value);      

        $rows = AspirantProyect::with('project', 
            'aspirant', 
            'aspirant.user', 
            'aspirant.user.gender', 
            'aspirant.user.city', 
            'aspirant.user.city.departament', 
            'aspirant.aspirant_type', 
            'aspirant.ethnic', 
            'aspirant.categoryAspirant') 
            ->where('id', '>', $variable->value)        
            ->orderBy('id')
            ->limit(100)
            ->get();
        /* $rows = Aspirant::with('user', 'user.gender', 'user.city', 'user.city.departament', 'aspirant_type', 'ethnic', 'categoryAspirant')
            ->where('aspirant_type_id', '<>', null)    
            ->where('id', '>', $variable->value)        
            ->orderBy('id')
            ->limit(100)
            ->get(); */

        if( $rows->count() === 0 ){
            return  true;
        }
        
        $finalData = collect();
        $lastId = 0;

        /* 
            aspirante [ id, has_project, created_at ]
            aspirant_type  [ name ]
            ethnic [ name ]
            category_aspirant [ name ]
            user  [ name, last_name, email, phone, address ]
            user - gender [ name ]
            user - city [ codigo, descripcion ]
            user - city - departament [ codigo, descripcion ]
        */
        foreach ($rows as $row){   
            $fullName = $row->aspirant->user->name . ' ' . $row->aspirant->user->last_name;
            $dateRegister = new Carbon($row->aspirant->created_at, 'America/Bogota');
            $aspirant_type = $row->aspirant->aspirant_type->name ? $row->aspirant->aspirant_type->name : '--';
            $phone = $row->aspirant->user->phone ? $row->aspirant->user->phone : '0';
            $address = $row->aspirant->user->address ? $row->aspirant->user->address : '--';
            $ethnic = $row->aspirant->ethnic ? $row->aspirant->ethnic->name : '--';
            $category_aspirant = $row->aspirant->categoryAspirant ? $row->aspirant->categoryAspirant->name : '--';
            $title_proyect = $row->project ? $row->project->title : '--';

            // Preguntas
            $head_house_hold = $row->aspirant->head_house_hold ? $row->aspirant->head_house_hold : ' -- ';
            $victim_conflict = $row->aspirant->victim_conflict ? $row->aspirant->victim_conflict : ' -- ';
            $disability = $row->aspirant->disability ? $row->aspirant->disability : ' -- ';
            $vinculado_ecopetrol = $row->aspirant->vinculado_ecopetrol ? $row->aspirant->vinculado_ecopetrol : ' -- ';
            $primer_empleo_ecopetrol = $row->aspirant->primer_empleo_ecopetrol ? $row->aspirant->primer_empleo_ecopetrol : ' -- ';
            $bachilleres_colombia_ecopetrol = $row->aspirant->bachilleres_colombia_ecopetrol ? $row->aspirant->bachilleres_colombia_ecopetrol : ' -- ';
           
            $finalData->push([
                $row->id,
                $dateRegister->toDateTimeString(),
                $aspirant_type,
                $fullName,
                $row->aspirant->user->email,
                $phone,
                $address,
                $title_proyect,
                $row->aspirant->user->gender->name,
                $row->aspirant->user->city->codigo,
                $row->aspirant->user->city->descripcion,
                $row->aspirant->user->city->departament->codigo,
                $row->aspirant->user->city->departament->descripcion,
                $ethnic,
                $category_aspirant,
                $head_house_hold,
                $victim_conflict,
                $disability,
                $vinculado_ecopetrol,
                $primer_empleo_ecopetrol,
                $bachilleres_colombia_ecopetrol,
            ]);
            $lastId = $row->id;
        }  

        $googleSheet->saveDataToSheet(
            $finalData->toArray(),
            '15GjdSiruqXLkaKYdHNNWXYuRnUbUntdvGMhVUwsfeNI',
            'info_aspirants',
        );

        /*$googleSheet->saveDataToSheet(
            $finalData->toArray(),
            '1Bcb7El9zLMo3Akw438ezaeuufKP-7tfiNyODKU_25EQ',
            'aspirants',
        );*/

        $variable->value = $lastId;
        $variable->save();

        return true; 
    }
}
