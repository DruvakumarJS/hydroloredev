<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ChatVerificationOtp extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    protected $templateId = 'd-7e98d51f48f74d789bd14m02826n52d9'; 
    
    public function __construct($user)
    {
        $this->user = $user;
      
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // echo '<pre>';
        // echo 'DDDDDDD';
        // print_r($this->user);
        // exit;
        // return $this->from('janagiraman@netiapps.com')useruser
        //        ->subject('Hydrolore')
        //        ->view('emails.chatVerificationOtp',["user"=>$this->user]);
        return $this->subject('Hydrolore')->view('emails.chatVerificationOtp');
    }
}
