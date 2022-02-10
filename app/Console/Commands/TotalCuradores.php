<?php

namespace App\Console\Commands;

use App\Models\Curador;
use Illuminate\Console\Command;
use App\Models\ReportVariable;
use App\Services\GoogleSheet;
use Carbon\Carbon;

class TotalCuradores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:totalCuradores';

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
            ->where('name', 'lastTotalCuradoresIDSync')
            ->first();
        
        $rows = Curador::with('user', 'category')
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
            $phone = $row->user->phone ? $row->user->phone : '0';

            $finalData->push([
                $row->id,
                $fullName,
                $row->user->email,
                $phone,
                $row->category->category,
                $dateRegister
            ]);
            $lastId = $row->id;
        }    

        $googleSheet->saveDataToSheet(
            $finalData->toArray(),
            '1anOENzRqciBLr4MOedByanxEo4BdPlj2KWAx76kh7Ws',
            'totalCuradores',
        );

        $variable->value = $lastId;
        $variable->save();

        return true; 
    }
}
