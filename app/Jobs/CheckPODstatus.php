<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\MasterSyncData;
use App\Models\Pod;
use App\Mail\PODstatusEmail;
use App\Models\Userdetail;
use App\Models\User;
use Mail;

class CheckPODstatus implements ShouldQueue
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
       $pods  = Pod::get();
       $data = array();

        foreach ($pods as $key => $value) {
            $time = date('Y-m-d H:i:s', strtotime('-6 hour'));

              if(MasterSyncData::where('pod_id' , $value->pod_id)->whereBetween('created_at' , [$time , date('Y-m-d H:i:s')])->doesntExist()){

                if(MasterSyncData::where('pod_id' , $value->pod_id)->exists()){
                  $details = MasterSyncData::where('pod_id' , $value->pod_id)->orderBy('id', 'DESC')->first();
                  $last_entry = date('Y-m-d H:i' , strtotime($details->created_at)); 
                }
                else {
                  $last_entry = '' ;
                }
                $user = Userdetail::where('id', $value->user_id)->first();

                $data[]=['user' => $user , 'POD_ID' => $value->pod_id, 'HUB_ID' => $value->hub_id , 'last_entry' => $last_entry , 'installation_date' => date('Y-m-d' , strtotime($value->created_at)) ];
                      
            }
            
        }
        
       
        if(sizeof($data)>0){
            $admins = User::where('role_id' , '1')->get();

            foreach($admins as $key=>$value){
                $emailid[]=$value->email;

             }

            Mail::to($emailid)->send(new PODstatusEmail($data));
            //$this->sendFCM($data);
        }
    }

    public function sendFCM($data){

        foreach($data as $key=>$value){
            // print_r($value['user']['user_id']);
            $ids[] = $value['user']['user_id'];

        }

        print_r($ids); 
       // die();

        $tokens = implode(',',$ids);
         print_r($tokens); 
       // die();

        $url = 'https://fcm.googleapis.com/fcm/send';
       // $FcmToken = User::whereNotNull('device_token')->pluck('device_token')->all();
        $FcmToken = User::whereNotNull('device_token')->where('id','1')->pluck('device_token')->get();
        
        print_r(json_encode($FcmToken)); die();
          
        $serverKey = env('FCM_SERVER_KEY');
  
        $data = [
            "registration_ids" => $FcmToken,

            "notification" => [
                "title" => "Device Not Responding",
                "body" => "Dear user, please check the power connections in the POD and see if red light ON. If not please contact Hydrolore team.  ", 
                "click_action" =>  "http://127.0.0.1:8000/" 

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
