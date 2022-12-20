<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminCredenetialsEmail extends Mailable
{
    use Queueable, SerializesModels;
     public $user;
     public $password;
     public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$password,$url)
    {
        $this->user = $user;
        $this->password = $password;
        $this->url = $url ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
         return $this->subject('Hydrolore Dashboard Login Credentials')->view('emails.admin_credentials');
    }
}
