<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RemainderMail extends Mailable
{
    use Queueable, SerializesModels;
    public $remainder ;
    public $expiry ;
    public $type;
    public $nutrients;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($remainder , $type , $expiry , $nutrients)
    {
        $this->remainder = $remainder;
        $this->type = $type ;
        $this->expiry = $expiry;
        $this->nutrients = $nutrients;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if($this->type == 'stocks'){

             return $this->subject('Stocks needs to be imported')->view('remainder.stocks');
        }

        if($this->type == 'expiry'){
            return $this->subject('Stocks Expiring')->view('remainder.expiry');
        }

        if($this->type == 'nutrients'){
            return $this->subject('Nutrients Supply')->view('remainder.nutrients');
        }
        
    }
}
