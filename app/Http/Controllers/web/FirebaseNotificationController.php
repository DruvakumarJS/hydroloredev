<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cultivation;
use App\Models\Userdetail;
use App\Models\Crop;

class FirebaseNotificationController extends Controller
{
  
 public function __construct()
    {
        $this->middleware('auth');
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('notification');
    }
    
    public function create()
    {
        //
    }

   
    public function store(Request $request)
    {
    
        auth()->user()->update(['device_token'=>$request->token]);
        return response()->json(['Token successfully stored.']);
    }


    public function show(Request $request)
    {
       
       // $url = 'https://fcm.googleapis.com/fcm/send';
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = User::whereNotNull('device_token')->pluck('device_token')->all();
          
        $serverKey = env('FCM_SERVER_KEY');
  
        $data = [
            "registration_ids" => $FcmToken,

            "notification" => [
                "title" => $request->title,
                "body" => $request->body, 
                "click_action" =>  "http://127.0.0.1:8000/tickets" 

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
        // print_r($data);
        // print_r($result);
        
    }

    public function dynamic_notification(){
      

       $harvest = Cultivation::where('harvesting_date' , date('Y-m-d'))->where('status', '1')->get();
       $harvest_array=array();
        foreach ($harvest as $key => $value) {
         $userdetail = Userdetail::where('id', $value->user_id)->first();
      
         $FcmToken= User::select('device_token')->where('id' ,$userdetail->user_id)->first();
          
         $harvest_array[]=['token' => $FcmToken->device_token , 'pod_id'=>$value->pod_id , 'channel' => $value->channel_no.$value->sub_channel , 'id' => $value->id];

        } 

       foreach ($harvest_array as $key2=>$value2) {

           $url = 'https://fcm.googleapis.com/fcm/send';  
            $serverKey = env('FCM_SERVER_KEY');
            $data = [
                "registration_ids" => array($value2['token']),

                "notification" => [
                    "title" => 'Hydrolore - '.$value2['pod_id'] ,
                    "body" => 'Hi..Start harvesting in Channel '.$value2['channel'],
                    "sound" => "default",
                    "image" => url('/').'/images/logo1.png',
                    "click_action" =>  $value2['id'] 

                ]
            ];
            $encodedData = json_encode($data);
        
            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            $result = curl_exec($ch);
            if ($result === FALSE) {  
               die('Curl failed: ' . curl_error($ch));
            }        
            $err = curl_error($ch);

           // print_r($result);
            curl_close($ch);
       }

       $this->addNutrition();

    }

    public function addNutrition(){
        $nutrients = Cultivation::where('nutrition_addition' , date('Y-m-d'))->where('status', '1')->get();
        $nutrients_array=array();
         foreach ($nutrients as $key => $value) {
          
         $userdetail = Userdetail::where('id', $value->user_id)->first();
      
         $FcmToken= User::select('device_token')->where('id' ,$userdetail->user_id)->first();
            //print_r($FcmToken->device_token);
           $nutrients_array[]=['token' => $FcmToken->device_token , 'pod_id'=>$value->pod_id , 'channel' => $value->channel_no.$value->sub_channel , 'id' => $value->id ];
 
         } 

       foreach ($nutrients_array as $key2=>$value2) {

           $url = 'https://fcm.googleapis.com/fcm/send';  
            $serverKey = env('FCM_SERVER_KEY');
            $data = [
                "registration_ids" => array($value2['token']),

                "notification" => [
                    "title" => 'Hydrolore - '.$value2['pod_id'] ,
                    "body" => 'Hi..Add Nutrients to Channel '.$value2['channel'], 
                    "click_action" =>  $value2['id'] 

                ]
            ];
            $encodedData = json_encode($data);
        
            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            $result = curl_exec($ch);
            if ($result === FALSE) {  
               die('Curl failed: ' . curl_error($ch));
            }        
            $err = curl_error($ch);

           // print_r($result);
            curl_close($ch);
       }

      $this->spray1();
    }

    public function spray1(){
        $spray1 = Cultivation::where('spray1' , date('Y-m-d'))->where('status', '1')->get();
       $spray1_array=array();
        foreach ($spray1 as $key => $value) {
         $userdetail = Userdetail::where('id', $value->user_id)->first();
      
         $FcmToken= User::select('device_token')->where('id' ,$userdetail->user_id)->first();
          //print_r($FcmToken->device_token);
         $spray1_array[]=['token' => $FcmToken->device_token , 'pod_id'=>$value->pod_id , 'channel' => $value->channel_no.$value->sub_channel , 'id' => $value->id];

        } 

       foreach ($spray1_array as $key2=>$value2) {

           $url = 'https://fcm.googleapis.com/fcm/send';  
            $serverKey = env('FCM_SERVER_KEY');
            $data = [
                "registration_ids" => array($value2['token']),

                "notification" => [
                    "title" => 'Hydrolore - '.$value2['pod_id'] ,
                    "body" => 'Plant Protection Sprays - Channel '.$value2['channel'], 
                    "click_action" =>  $value2['id'] 

                ]
            ];
            $encodedData = json_encode($data);
        
            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            $result = curl_exec($ch);
            if ($result === FALSE) {  
               die('Curl failed: ' . curl_error($ch));
            }        
            $err = curl_error($ch);

           // print_r($result);
            curl_close($ch);
       }

      $this->spray2();
    }

    public function spray2(){
        $spray2 = Cultivation::where('spray2' , date('Y-m-d'))->where('status', '1')->get();
       $spray2_array=array();
        foreach ($spray2 as $key => $value) {
         $userdetail = Userdetail::where('id', $value->user_id)->first();
      
         $FcmToken= User::select('device_token')->where('id' ,$userdetail->user_id)->first();
          //print_r($FcmToken->device_token);
         $spray2_array[]=['token' => $FcmToken->device_token , 'pod_id'=>$value->pod_id , 'channel' => $value->channel_no.$value->sub_channel , 'id' => $value->id];

        } 

       foreach ($spray2_array as $key2=>$value2) {

           $url = 'https://fcm.googleapis.com/fcm/send';  
            $serverKey = env('FCM_SERVER_KEY');
            $data = [
                "registration_ids" => array($value2['token']),

                "notification" => [
                    "title" => 'Hydrolore - '.$value2['pod_id'] ,
                    "body" => 'Crop Fertigation - 1 - Channel '.$value2['channel'], 
                    "click_action" =>  $value2['id'] 

                ]
            ];
            $encodedData = json_encode($data);
        
            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            $result = curl_exec($ch);
            if ($result === FALSE) {  
               die('Curl failed: ' . curl_error($ch));
            }        
            $err = curl_error($ch);

           // print_r($result);
            curl_close($ch);
       }

      $this->spray3();
    }

    public function spray3(){
        $spray3 = Cultivation::where('spray3' , date('Y-m-d'))->where('status', '1')->get();
       $spray3_array=array();
        foreach ($spray3 as $key => $value) {
         $userdetail = Userdetail::where('id', $value->user_id)->first();
      
         $FcmToken= User::select('device_token')->where('id' ,$userdetail->user_id)->first();
          //print_r($FcmToken->device_token);
         $spray3_array[]=['token' => $FcmToken->device_token , 'pod_id'=>$value->pod_id , 'channel' => $value->channel_no.$value->sub_channel , 'id' => $value->id];

        } 

       foreach ($spray3_array as $key2=>$value2) {

            $url = 'https://fcm.googleapis.com/fcm/send';  
            $serverKey = env('FCM_SERVER_KEY');
            $data = [
                "registration_ids" => array($value2['token']),

                "notification" => [
                    "title" => 'Hydrolore - '.$value2['pod_id'] ,
                    "body" => 'Crop Fertigation - 2 - Channel '.$value2['channel'], 
                    "click_action" =>  $value2['id'] 

                ]
            ];
            $encodedData = json_encode($data);
        
            $headers = [
                'Authorization:key=' . $serverKey,
                'Content-Type: application/json',
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);        
            curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
            $result = curl_exec($ch);
            if ($result === FALSE) {  
               die('Curl failed: ' . curl_error($ch));
            }        
            $err = curl_error($ch);

            //print_r($result);
            curl_close($ch);
       }

      
    }


    

}
