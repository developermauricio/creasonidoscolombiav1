<?php

namespace App\Console\Commands;

use App\Models\Proyect;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use \PhpMqtt\Client\Facades\MQTT;
use Illuminate\Support\Facades\Log;

class EndTimeProject extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:end_time_edit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Permite verificar si vencio las 24 horas para poder editar un proyecto';

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
    public function handle()
    {
        $date = Carbon::now();
        $project = Proyect::where('end_time', '<=', $date->format('Y-m-d H:i:s'))->where('available_edit', 1)->with('aspirant.user', 'category')->first();
        //Log::debug('project...');
        //Log::debug($project);

        /* $email = $project->aspirant[0]->user->email;
        $name = $project->aspirant[0]->user->name;
        $last_name = $project->aspirant[0]->user->last_name;
        $project_name = $project->title; */
//        $project_category = $project->category->category;
        if($project){
            $email = $project->aspirant[0]->user->email;
            $name = $project->aspirant[0]->user->name;
            $last_name = $project->aspirant[0]->user->last_name;
            $project_name = $project->title;

            $project->available_edit = 2;
            $project->state = 2;
            $project->save();

            MQTT::publish('subsanador_project', 'Nuevo proyecto en la bandeja');
            Mail::to($project->aspirant[0]->user->email)->send(new \App\Mail\Aspirant\EndTimeProject($email, $name, $last_name, $project_name));

        }
    }
}
