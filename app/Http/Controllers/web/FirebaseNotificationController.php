<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


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
         print_r($result);
        
    }

    
    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function send_custome_notification(){

    }
}
