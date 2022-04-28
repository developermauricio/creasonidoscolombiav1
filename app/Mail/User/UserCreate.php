<?php

namespace App\Mail\User;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserCreate extends Mailable
{
    use Queueable, SerializesModels;
    private $email;
    private $name;
    private $last_name;
    private $password;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($email, $name, $last_name, $password)
    {
        $this->name = $name;
        $this->last_name = $last_name;
        $this->password = $password;
        $this->email = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject(config('app.name').'-'. 'CREDENCIALES DE ACCESO' )
            ->markdown('mails.user.user-mail-create')
            ->with('email',$this->email)
            ->with('name',$this->name)
            ->with('last_name',$this->last_name)
            ->with('password',$this->password);
    }
}
