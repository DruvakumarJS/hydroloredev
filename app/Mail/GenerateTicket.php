<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateTicket extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user,$sr_no,$problems;
    
    public function __construct($user, $sr_no,$problems)
    {
        $this->user = $user;
        $this->sr_no = $sr_no;
        $this->problems=$problems;
      
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Hydrolore - Ticket')->view('emails.generateTicket');
    }
}
