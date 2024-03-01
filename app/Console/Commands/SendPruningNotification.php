<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pod;
use App\Models\Userdetail;
use App\Models\User;

class SendPruningNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pruning:notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending Pruning notification every 3 days';

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
        $Pods = Pod::get();
        $userarray=array();

        foreach ($Pods as $key => $value) {
            $install_date = date('Y-m-d',strtotime($value->created_at));
            $today = date('Y-m-d');
 
            $difference = strtotime($today) - strtotime($install_date) ;


            $pod_age = round($difference / (60 * 60 * 24));


            if($pod_age > 25){
                $pruningage = intval($pod_age) - (25) ;

                if($pruningage % 7 == 0){

                    if(in_array($value->user_id, $userarray)){

                    }else{
                        $userarray[] = $value->user_id;
                    }
                }
                           
            }
        }

       // die();

        $users = Userdetail::whereIn('id',$userarray)->get();
        $tokens = array();

        foreach ($users as $key2 => $value2) {
            $data=User::select('device_token')->where('id' , $value2->user_id)->first();
            $tokens[]=$data->device_token;
        }

        //print_r($tokens); die();

        if(sizeof($tokens)>0){
        
            $url = 'https://fcm.googleapis.com/fcm/send';
        //$FcmToken = User::whereNotNull('device_token')->pluck('device_token')->all();

       // print_r($FcmToken); die();
          
        $serverKey = env('FCM_SERVER_KEY');


  
        $data = [
            "registration_ids" => $tokens,

            "notification" => [
                "title" => "Hydrolore",
                "body" => "Pruning to be done",

            ]
        ];
        $encodedData = json_encode($data);
    
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

      //  print_r($data); die();
    
        $ch = curl_init();
      
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
           
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
       
        $err = curl_error($ch);
        
        curl_close($ch);
        }
    }
}
