<?php

namespace App\Http\Controllers;

use App\Models\Enquiry;
use Illuminate\Http\Request;
use App\Models\Userdetail;
use App\Models\User;
use App\Models\Hub;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeMail;
use Mail;

class EnquiryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Enquiry::orderBy('id','DESC')->get();
        return view('enquiry.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $insert = Enquiry::create([
            'firstname' => $request->firstname ,
            'lastname' => $request->lastname ,
            'email' => $request->email ,
            'mobile' => $request->mobile ,
            'address' => $request->address ,
            'type_of_building' => $request->type ,
            'installation_date' => $request->date ,
            'no_of_channels' => $request->channels ,
            'crops' => $request->crops ,
            'require_monitoring' => $request->monitor ,
            'comments' => $request->comments  ]);

        if($insert){
            return redirect()->route('enquiry');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $value = Enquiry::where('id', $id)->first();
        return view('enquiry/convert',compact('value'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function edit(Enquiry $enquiry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$enquiry)
    {
         $insert = Enquiry::where('id', $enquiry)->update([
            'firstname' => $request->firstname ,
            'lastname' => $request->lastname ,
            'email' => $request->email ,
            'mobile' => $request->mobile ,
            'address' => $request->address ,
            'type_of_building' => $request->type ,
            'installation_date' => $request->date ,
            'no_of_channels' => $request->channels ,
            'crops' => $request->crops ,
            'require_monitoring' => $request->monitor ,
            'comments' => $request->comments  ]);

        if($insert){
            return redirect()->route('enquiry');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Enquiry  $enquiry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enquiry $enquiry)
    {
        //
    }

    public function convert(Request $request){
      
       $validator = Validator::make($request->all(), [
            'firstname' => 'required|min:3',
            'mobile' => 'required|min:10|unique:userdetails',
            'email' => 'required|email|unique:userdetails',
            'location' => 'required',
            'address' => 'required',
            'hub_id' => 'required|unique:userdetails',
        ]);


       if ($validator->fails()) {

            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }
    
      else{

      
       $hint='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
       $password='SYS'.substr(str_shuffle($hint), 0, 9);
       $encrypted_password=Hash::make($password);

       $user=new User();
         $user->name=$request->firstname." ".$request->lastname;
         $user->email=$request->email;
         $user->role_id="3";
         $user->password=Hash::make($password);
    
       if($user->save())
       {
        $user_login_details=User::where('email',$request->email)->first();
        $user_id=$user_login_details->id;
       // $otp = rand('0000','9999');
        $otp = '1234';
        $request->request->add(['user_id'=>$user_id]);
        $request->request->add(['otp'=>$otp]);

        $data = $request->all();
    
        $insert=Userdetail::create($data);

        $user=Userdetail::where('mobile',$request->mobile)->first();

        $hubdata=Hub::create([
              'hub_id'=>$user->hub_id,
              'user_id'=>$user->id,
              'hub_name'=>$user->hub_id,
              'hub_location'=>$user->location,
              'pods_count'=>'0',
              'status'=>'active'

            ]);

    
         if($hubdata)
         { 
            $delete_enquiry = Enquiry::where('id', $request->enquiry_id)->delete();
            $path = public_path('uploads');
            $filename = $path.'/'."Hydrolore Crop Maintaincance Guide.pdf";
            $url = url('/');
         
        // Mail::to($user->email)->send(new WelcomeMail($user ,$filename , $password , $url ));

         }

        }
        else
        {
            return redirect()->route('Something went wrong')
                        ->withInput();

        }

        return redirect()->route('show_users');

     }

   

    }
}
