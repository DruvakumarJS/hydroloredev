<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class WelcomeMail extends Mailable
{
    use Queueable, SerializesModels;
     public $user;
     public $filename;
     public $password;
     public $url;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user,$filename,$password,$url)
    {
        $this->user = $user;
        $this->filename = $filename;
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
        //return $this->view('view.name');
        return $this->subject('Welcome to Hydrolore')->view('emails.welcome')->attach($this->filename);
    }
}
