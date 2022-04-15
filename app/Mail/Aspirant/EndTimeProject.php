<?php

namespace App\Mail\Aspirant;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EndTimeProject extends Mailable
{
    use Queueable, SerializesModels;
    private $email;
    private $name;
    private $last_name;
    private $project_name;
//    private $project_category;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name, $last_name, $project_name)
    {
        $this->email = $email;
        $this->name = $name;
        $this->last_name = $last_name;
        $this->project_name = $project_name;
//        $this->project_category = $project_category;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(config('app.name').'-'. 'PROPUESTA MUSICAL HA PASADO HA REVISIÓN' )
            ->markdown('mails.aspirant.mail-update-project-end-time')
            ->with('email',$this->email)
            ->with('name',$this->name)
            ->with('last_name',$this->last_name)
            ->with('project_name',$this->project_name);
    }
}
