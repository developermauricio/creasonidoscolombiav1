<?php

namespace App\Console\Commands;

use App\Models\Aspirant;
use App\Models\ReportVariable;
use App\Services\GoogleSheet;
use Carbon\Carbon;
use Illuminate\Console\Command;

class TotalAspirantRegistered extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:totalAspirantRegistered';

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
            ->where('name', 'lastTotalAspRegIDSync')
            ->first();
        
        /* if ( $variable->value > 100 ) {
            $variable->value = $variable->value - 100;
        }
        Log::debug('lastTotalAspRegIDSync...');
        Log::debug($variable->value);      */ 
        
        $rows = Aspirant::with('user')
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
            $dateRegister = new Carbon($row->created_at, 'America/Bogota');
            $phone = $row->user->phone ? $row->user->phone : '--';
            //$project = $row->has_project == 1 ? 'Si' : 'No';

            $finalData->push([
                $row->id,
                $fullName,
                $row->user->email,
                $phone,
                $row->has_project,
                $dateRegister->toDateTimeString(),
            ]);
            $lastId = $row->id;
        }    

        $googleSheet->saveDataToSheet(
            $finalData->toArray(),
            '1nSSNTSDP4XYmcRiou3ge2eH_UnZLipkkTj0R8WR0CFM',
            'totalAspReg',
        );

        $variable->value = $lastId;
        $variable->save();

        return true; 
    }
}
