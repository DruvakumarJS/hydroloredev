<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Http\Request;
use App\Models\Userdetail;
use App\Http\Controllers\web\FirebaseNotificationController;
use App\Mail\WelcomeMail;
use Mail;

class SendNotifications implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $fcm = new FirebaseNotificationController;

        $data = new Request([
            'title' => 'Hydrolore' ,
            'body' => 'New Crop Added to your POD ' ]);
      
        // $fcm->show($data);
           $fcm->dynamic_notification();
  
    }
}
