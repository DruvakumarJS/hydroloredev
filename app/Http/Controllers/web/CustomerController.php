<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Hub;
use App\Models\Pod;
use App\Models\Alert;
use App\Models\Userdetail;
use App\Models\PodMaster;
use App\Models\Questions;
use App\Models\User;
use Illuminate\Support\Facades\Hash;  
use APP\Http\Controllers\web\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\GenerateTicket;

class CustomerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
  

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $date=date('Y-m-d');

         $id=auth()->user()->id;

         $user_id=Userdetail::where('user_id',$id)->first();

    
         $pods=Pod::where('user_id',$user_id->id)->get();

       //  print_r($user_id->id);die();
       
         return view('customerHome',compact('pods'));


      
       }



       public function mypods()
       {

        $id=auth()->user()->id;

        $user_id=Userdetail::where('user_id',$id)->first();

    
         $pods=Pod::where('user_id',$user_id->id)->paginate(10);
       
        return view('customer/customer_pods',compact('pods'));

       }



       public function myhubs(){

         $id=auth()->user()->id;

        $user_id=Userdetail::where('user_id',$id)->first();

        $hubs_details=Hub::where('user_id',$user_id->id)->get();
        $podMaster=PodMaster::all();


        return view('customer/customer_hubs',compact('hubs_details', 'podMaster'));

       }


       public function mytickets(){

        $authid=auth()->user()->id;
        $user_data=Userdetail::where('user_id',$authid)->first();

        $tickets=Ticket::where('user_id',$user_data->id)->paginate(10);

       return view('customer/customer_tickets',compact('tickets'));

       }

       public function raiseticket(){

         $questions=Questions::all();


           $email=auth()->user()->email;

          // print_r($email);die();
           return view('customer/customer_generateticket',compact('email','questions'));      
        

       }

       public function saveticket(Request $request)
       {


        $validator = Validator::make($request->all(), [
            
            'email' => 'required|email',
            
        ]);


       if ($validator->fails()) {
            return redirect()->route('raise_ticket')
                        ->withErrors($validator)
                        ->withInput();
        }


       $user=Userdetail::where('email',$request->email)->first();

       if($user){

         $ticket_data=array();

    
       foreach ($request->issue as $key => $value) {
          if($value=='1')
          {
             array_push($ticket_data,$key);
          }
         
       }

    
        if(sizeof($ticket_data)==0)
        {
            return redirect()->route('raise_ticket')->with('message', 'Please select at least one issue')->withInput();
        }


       

        $problems=implode('$', $ticket_data);


             $user_id=$user->id;
             $hub_id=$user->hub_id;




        $hint='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $sr_no='AD'.substr(str_shuffle($hint), 0, 8);
        $date=date('Y-m-d');

        


         //->Where('created_at', 'like', '%'.$date.'%')
         //->WhereRaw('Date(created_at)',$date)

        $checticket=Ticket::where('user_id',$user_id)
                                         ->Where('created_at', 'like', $date.'%')
                                         ->Where('sr_no','not like','SYS'.'%')
                                        ->first();

                                    
        if($checticket){
            return redirect()->route('raise_ticket')->with('message', 'Ticket has been already generated')->withInput();
        }
        
       
        
        $Insert=Ticket::create([
            'subject'=>$problems,
            'status'=>'1',
            'user_id'=> $user_id,
            'hub_id'=> $hub_id,
            'pod_id'=> '0',
            'sr_no'=> $sr_no]);

         Mail::to($user->email)->send(new GenerateTicket($user, $sr_no,$problems));

        return redirect()->route('my_tickets');
       

       }
       else{
        
         return redirect()->route('my_tickets')->with('message', 'This Email ID is not registered with Hydrolore')->withInput();

       }
       

       }

       public function reset_password(){
        return view('customer/resetpassword');
       }

       public function update_password(Request $request)
       {

            $email=$request->email;
            $password=$request->password;
            $password_confirmation=$request->password_confirmation;

            if($password!=$password_confirmation){

                 return redirect()->route('reset_password')
                                ->with('message', 'password and confirm password do not match')
                                ->withInput();
            }
            else{
                 $admin=User::where('email',$email)
                              ->update(['password'=>Hash::make($password)]);

                             return redirect()->route('customer-dashboard');

            }

       }

   
}
