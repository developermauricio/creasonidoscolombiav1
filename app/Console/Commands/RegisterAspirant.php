<?php

namespace App\Console\Commands;

use App\Models\Aspirant;
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

        Log::debug('Comando...');
        Log::debug($variable);
        
        $rows = Aspirant::with('user', 'aspirantType')
            ->where('aspirant_type_id', '<>', null)
            ->where('id', '>', $variable->value)
            ->orderBy('id')
            ->limit(100)
            ->get();

        if( $rows->count() === 0 ){
            return  true;
        }
        
        $finalData = collect();
        $lastId = 0;

        foreach ($rows as $row){      
            $fullName = $row->user->name . ' ' . $row->user->last_name;
            $document = $row->user->document ? $row->user->document : 'Por definir';
            $dateRegister = new Carbon($row->created_at, 'America/Bogota');
            $phone = $row->user->phone ? $row->user->phone : '0';
            $aspirant_type = $row->aspirant_type->name ? $row->aspirant_type->name : 'Por definir';

            $finalData->push([
                $row->id,
                $document,
                $fullName,
                $row->user->email,
                $phone,
                $aspirant_type,
                $dateRegister
            ]);
            $lastId = $row->id;
        }    

        $googleSheet->saveDataToSheet(
            $finalData->toArray(),
            '1Bcb7El9zLMo3Akw438ezaeuufKP-7tfiNyODKU_25EQ',
            'aspirants',
        );

        $variable->value = $lastId;
        $variable->save();

        return true; 
    }
}
