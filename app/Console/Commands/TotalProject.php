<?php

namespace App\Console\Commands;

use App\Models\Proyect;
use Illuminate\Console\Command;
use App\Models\ReportVariable;
use App\Services\GoogleSheet;
use Carbon\Carbon;

class TotalProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:totalProjects';

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
            ->where('name', 'lastTotalProjectIDSync')
            ->first();

        
        $rows = Proyect::with('category')
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
            $dateRegister = new Carbon($row->created_at, 'America/Bogota');

            $finalData->push([
                $row->id,
                $row->title,
                $row->state,
                $row->description,
                $row->category->category,
                $dateRegister
            ]);
            $lastId = $row->id;
        }    

        $googleSheet->saveDataToSheet(
            $finalData->toArray(),
            '1-ZAFL25c0UiCoPm_BXdrDdF5nZllhVRHyRtALS29CGk',
            'projects',
        );

        $variable->value = $lastId;
        $variable->save();

        return true; 
    }
}
