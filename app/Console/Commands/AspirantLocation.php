<?php

namespace App\Console\Commands;

use App\Models\Aspirant;
use App\Models\ReportVariable;
use App\Services\GoogleSheet;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class AspirantLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:aspirantLocation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            ->where('name', 'lastLocationIDSync')
            ->first();

        Log::debug('Comando...');
        Log::debug($variable);
        
        $rows = Aspirant::with('user', 'user.city', 'user.city.departament')
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

            $finalData->push([
                $row->id,
                $document,
                $fullName,
                $row->user->email,
                $phone,
                $row->user->city->codigo,
                $row->user->city->descripcion,
                $row->user->city->departament->codigo,
                $row->user->city->departament->descripcion,
                $dateRegister
            ]);
            $lastId = $row->id;
        }    

        $googleSheet->saveDataToSheet(
            $finalData->toArray(),
            '1ML2R5sWEZtH8UQXYh_4YzA7AVe1jRnFJ6LV7TMZW_fY',
            'location',
        );

        $variable->value = $lastId;
        $variable->save();

        return true; 
    }
}
