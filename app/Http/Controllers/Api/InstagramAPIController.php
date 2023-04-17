<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InstagaramToken;
use Illuminate\Support\Facades\Http;
use App\Models\Pod;

class InstagramAPIController extends Controller
{
     public function get_instatoken()
     {
     	$date = date('Y-m-d H:i:s');
     
     	$insta_token_data=InstagaramToken::first();

     	//print_r($insta_token_data);

     	$token = $insta_token_data->insta_token ;
     	$token_expiry_date = $insta_token_data->expiry_date ;

     
     	if($date <= $token_expiry_date)
     	{
           // print_r("old token");

             return response()->json([
		            'status' => 1,
		            'message' => 'refreshed token',
		            'token'=> $token
		        ],200);
     	}
     	else 
     	{
          //  print_r("refreshed token");

            $apiURL = "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token=".$token;

            $response = Http::get($apiURL);

            $responseBody = json_decode($response->getBody(), true);
  
            $refreshed_token = $response['access_token'];
           
            $expires_in = $response['expires_in'];

          
            $expiry_date =  date("Y-m-d H:i:s", strtotime("+$expires_in sec"));


            $update = InstagaramToken::where('id','!=','0')
                                        ->update(
            	                          ['insta_token' => $refreshed_token,
            	                          'start_date' => $date ,
            	                          'expiry_date' => $expiry_date]
                                                );


             return response()->json([
		            'status' => 1,
		            'message' => 'refreshed token',
		            'token'=> $refreshed_token
		        ],200);

     	}

     	

     }

  
}
