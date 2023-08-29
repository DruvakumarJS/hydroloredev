<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Userdetail;
use App\Models\Pod;
use App\Models\User;
use GuzzleHttp\Exception\GuzzleException;
use http\Client;
use Illuminate\Support\Facades\Http;
//use GuzzleHttp\Exception\GuzzleException;

class LoginController extends Controller
{
   /* public static function sendLoginOtp($receipientno, $otp){
        $client = new \GuzzleHttp\Client();
        if ($receipientno) {

            // $username = "manoj.p@netiapps.com";
            // $hash = "c036e85abe2efe9d3ccce6f9495dc320778f5d56370424f1bf602135d9efd4f8";

            $username =  env('TEXTLOCAL_USERNAME');
            $hash =  env('TEXTLOCAL_HASH');
        
            // Config variables. Consult http://api.textlocal.in/docs for more info.
            $test = "0";
        
            // Data for text message. This is the text message data.
            $sender = "plawrk"; // This is who the message appears to be from.
            $numbers = $receipientno; // A single number or a comma-seperated list of numbers
            $message = "Dear User Please use OTP $otp Regards Planetwork";
            
            // A single number or a comma-seperated list of numbers
            $message = urlencode($message);

            $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
            $ch = curl_init('http://api.textlocal.in/send/?');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch); // This is the result from the API
            curl_close($ch);

        } else {
            throw new \Exception("Mobile number not available", Response::HTTP_PRECONDITION_FAILED);
        }
    }*/

    public function verify_login(Request $request){
    	
        $data=array();
    	if (Userdetail::where('Mobile', $request->mobile)->exists()) {
            $user = Userdetail::where('Mobile', $request->mobile)->first();
          //  print_r($user->otp_verified);die();

            $is_otp_verified = $user->otp_verified;

            //if($is_otp_verified == '1'){
            	$pods = Pod::select('pod_id','status' ,'location')->where('user_id' , $user->id)->get();
            	$podarray=array();

            	foreach ($pods as $key => $value) {
            	  $podarray[]=['pod_id'=>$value->pod_id , 'status' => $value->status , 'location' => $value->location ];
            	}

            	$data = [
            		'user_id' => $user->id ,
            		'first_name' => $user->firstname ,
            		'last_name' => $user->lastname,
            		'mobile' => $user->mobile,
            		'email' => $user->email,
            		'hub_id' => $user->hub_id,
                    'file_directory' => url('/').'/profile/',
                    'image' => $user->profile_image,
            		'pods'=> $podarray];

            	return response()->json([
    		       'status'=> '1',
    		      // 'otp_verified'=> '1',
    		       'message'=> 'Login Successful',
    		       'data'=>$data ]);
            /*}
            else {
            	return response()->json([
    		       'status'=> '1',
    		       'otp_verified'=> '0',
    		       'message'=> 'Please Verify OTP',
    		       'data'=>$data ]);

            }*/

    	}
    	else {
    		return response()->json([
    		       'status'=> '0',
    		      // 'otp_verified'=> '0',
    		       'message'=> 'Invalid Mobile Number',
    		       'data'=>$data ]);
    	}
        
    }

    public function get_otp(Request $request){
       $otp = '';
        if (Userdetail::where('id', $request->user_id)->exists()) {
            $otp = rand('1111', '9999');
            $user = Userdetail::where('id', $request->user_id)->first();
           // $otp = '1234';

            $updateotp = Userdetail::where('id', $request->user_id)->update(['otp' => $otp]);

            $hash = env('TEXTLOCAL_apikey');
    
            // Message details
            $name = $user->firstname;
           
            $numbers = $user->mobile;
            $sender = 'hydrlr';
           // $message1 = "Dear ".$name.", Welcome to Hydrolore.Please use OTP".$otp." to Login.";
            $message = "Dear ".$name.", Welcome to Hydrolore. Please use OTP ".$otp." to Login.";

            print_r($message);
         
           // $numbers = implode(',', $numbers);
         
            // Prepare data for POST request
            $data = array('api_key' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
         
            // Send the POST request with cURL
            $ch = curl_init('https://api.textlocal.in/send/');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            
            // Process your response here
           // echo $response;

            if($updateotp){
                return response()->json([
                   'status'=> '1',
                   'message'=> 'OTP sent successfully',
                   ]);
            }
        }
        else {
            return response()->json([
                   'status'=> '0',
                   'message'=> 'UnAuthorised',
                   ]);
        }
    }

    public function verify_otp(Request $request){
        $data= array();

    	if (Userdetail::where('id', $request->user_id)->exists()) {
    		$user = Userdetail::where('id', $request->user_id)->first();

    		if($user->otp == $request->otp){

    			$update = Userdetail::where('id' , $request->user_id)->update(['otp_verified' => 1 , 'is_loggedin'=>1 , 'last_seen' => date('Y-m-d H:i:s')]);

    			$pods = Pod::select('pod_id','status' ,'location')->where('user_id' , $request->user_id)->get();
            	$podarray=array();

            	foreach ($pods as $key => $value) {
            	  $podarray[]=['pod_id'=>$value->pod_id , 'status' => $value->status , 'location' => $value->location ];
            	}

            	$data = [
            		'user_id' => $user->id ,
            		'first_name' => $user->firstname ,
            		'last_name' => $user->lastname,
            		'mobile' => $user->mobile,
            		'email' => $user->email,
            		'hub_id' => $user->hub_id,
                    'file_directory' => url('/').'/profile/',
                    'image' => $user->profile_image,
            		'pods'=> $podarray];
                
                return response()->json([
    		       'status'=> '1',
    		       //'otp_verified'=> '1',
    		       'message'=> 'OTP verified',
    		       'data'=>$data ]);
    		}
    		else{

    			return response()->json([
    		       'status'=> '0',
    		       //'otp_verified'=> '0',
    		       'message'=> 'Invalid OTP',
    		       'data'=>$data ]);
    		}
    	}
    	else {

            return response()->json([
    		       'status'=> '0',
    		      // 'otp_verified'=> '0',
    		       'message'=> 'UnAuthorised',
    		       'data'=>$data ]);
    	}
    }

    public function mydetails(Request $request){
    	 $data= array();

    	if (Userdetail::where('id', $request->user_id)->exists()) {
    		$user = Userdetail::where('id', $request->user_id)->first();

    		$update = Userdetail::where('id' , $request->user_id)->update(['otp_verified' => 1 , 'is_loggedin'=>1 , 'last_seen' => date('Y-m-d H:i:s')]);

    			$pods = Pod::select('pod_id','status' ,'location')->where('user_id' , $request->user_id)->get();
            	$podarray=array();

            	foreach ($pods as $key => $value) {
            	  $podarray[]=['pod_id'=>$value->pod_id , 'status' => $value->status , 'location' => $value->location ];
            	}

            	$data = [
            		'user_id' => $user->id ,
            		'first_name' => $user->firstname ,
            		'last_name' => $user->lastname,
            		'mobile' => $user->mobile,
            		'email' => $user->email,
            		'hub_id' => $user->hub_id,
                    'file_directory' => url('/').'/profile/',
                    'image' => $user->profile_image,
            		'pods'=> $podarray];
                
                return response()->json([
    		       'status'=> '1',
    		       'data'=>$data ]);

    	}
    	else {
    		 return response()->json([
    		       'status'=> '0',
    		       'data'=>$data ]);
    	}

    }

    public function send_otp(Request $request){

    $hash = env('TEXTLOCAL_apikey');
    
    // Message details
    $name = "Druva";
    $otp = "1234";
    $numbers = "918792422947";
    $sender = 'hydrlr';
   // $message1 = "Dear ".$name.", Welcome to Hydrolore.Please use OTP".$otp." to Login.";
    $message = "Dear ".$name.", Welcome to Hydrolore. Please use OTP ".$otp." to Login.";

    print_r($message);
 
   // $numbers = implode(',', $numbers);
 
    // Prepare data for POST request
    $data = array('api_key' => $hash, 'numbers' => $numbers, "sender" => $sender, "message" => $message);
 
    // Send the POST request with cURL
    $ch = curl_init('https://api.textlocal.in/send/');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    // Process your response here
    echo $response;

   
    }

    public function update_profile(Request $request){
       // print_r($request->Input()); die();

        if(Userdetail::where('id', $request->user_id)->exists()){

            if(Userdetail::where('mobile',$request->mobile)->where('id','!=',$request->user_id)->exists()){
                 return response()->json([
                   'status'=> '0',
                   'message' => 'Mobile number already exists'
                     ]);
            }

            else if(Userdetail::where('email',$request->email)->where('id','!=',$request->user_id)->exists()){
                 return response()->json([
                   'status'=> '0',
                   'message' => 'Email already exists'
                     ]);
            }
            else {
                
                $fileName = '';
                 if($file = $request->hasFile('image')) {
             
                    $file = $request->file('image') ;
                   // $fileName = $file->getClientOriginalName() ;
                    
                   // $newfilename = round(microtime(true)) . '.' . end($temp);
                    $temp = explode(".", $file->getClientOriginalName());
                    $fileName="profile".$request->user_id. '.' . end($temp);
                   
                    $destinationPath = public_path().'/profile' ;
                    $file->move($destinationPath,$fileName);
                    
                 }


                $update = Userdetail::where('id', $request->user_id)->update([
                    'firstname' => $request->firstname ,
                    'lastname' => $request->lastname ,
                    'mobile' => $request->mobile ,
                    'email' => $request->email,
                    'profile_image' => $fileName]);

                if($update){
                    $user = Userdetail::where('id', $request->user_id)->first();

                    $update_user = User::where('id', $user->user_id)->update([
                        'name' =>$request->firstname." ".$request->lastname ,
                        'email' => $request->email ]);

                    if($update_user){

                    $user = Userdetail::where('Mobile', $request->mobile)->first();
                    $pods = Pod::select('pod_id','status' ,'location')->where('user_id' , $user->id)->get();
                    $podarray=array();

                    foreach ($pods as $key => $value) {
                      $podarray[]=['pod_id'=>$value->pod_id , 'status' => $value->status , 'location' => $value->location ];
                    }

                    $data = [
                    'user_id' => $user->id ,
                    'first_name' => $user->firstname ,
                    'last_name' => $user->lastname,
                    'mobile' => $user->mobile,
                    'email' => $user->email,
                    'hub_id' => $user->hub_id,
                    'file_directory' => url('/').'/profile/',
                    'image' => $user->profile_image,
                    'pods'=> $podarray];

                    return response()->json([
                       'status'=> '1',
                       'message' => 'profile updated successfully',
                       'data'=>$data
                         ]);
                    }
                    else {
                        return response()->json([
                           'status'=> '0',
                           'message' => 'Something went wrong..'
                             ]);
                    }
                }
            }

            

        }
        else{
            return response()->json([
                   'status'=> '0',
                   'message' => 'UnAuthorized'
                     ]);
        }
    }
}
