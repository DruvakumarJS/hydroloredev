<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use Illuminate\Support\Facades\Validator;
use App\Models\Userdetail;
use App\Models\Questions;
use Illuminate\Support\Facades\Mail;
use App\Mail\TriggerEmail;
use App\Mail\CriticalEmail;
use App\Mail\GenerateTicket;
use DB;
use Illuminate\Support\Facades\Auth;


class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $date=date('Y-m-d');
        $user = Auth::user();
        $tickets=Ticket::when(($user->role_id == '3'), function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })
        ->orderByRaw('FIELD(status , "1" , "2" ,"0")')
        ->paginate(10);
        return view('ticket/tickets',compact('tickets'));
              
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
     
    
        $validator = Validator::make($request->all(), [
            
            'email' => 'required|email',
            
        ]);


       if ($validator->fails()) {
            return redirect()->route('redirect_add_tickets')
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
            return redirect()->route('redirect_add_tickets')->with('message', 'Please select at least one issue')->withInput();
        }


       

        $problems=implode('$', $ticket_data);

       // print_r($problems);die();

        /*foreach ($user as $key => $value) {
            
            $user_id=$value->id;
            $hub_id=$value->hub_id;

        }*/

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
            return redirect()->route('redirect_add_tickets')->with('message', 'Ticket has been already generated')->withInput();
        }
        
       
        
        $Insert=Ticket::create([
            'subject'=>$problems,
            'status'=>'1',
            'user_id'=> $user_id,
            'hub_id'=> $hub_id,
            'pod_id'=> '0',
            'sr_no'=> $sr_no]);

         Mail::to($user->email)->send(new GenerateTicket($user, $sr_no,$problems));

        return redirect()->route('show_tickets');
       


       }
       else{
        
         return redirect()->route('redirect_add_tickets')->with('message', 'This Email ID is not registered with Hydrolore')->withInput();

       }
       

        
   

       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {  

        $questions=Questions::all();


        if($request->email)
        {
           $email=$request->email;
           return view('ticket/add_tickets_form',compact('email','questions'));      
        }
        else {
             return view('ticket/add_tickets_form',compact('questions'));
        }
        
      
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tickets=Ticket::where('sr_no',$id)->first();
        
        return view('ticket/ticket_details',compact('id','tickets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       
       $action=$request->action;

       print_r($request->input());
     

       if($action=='save')
       {
          $status=$request->status;
          $srno=$request->sr_no;

          $update=Ticket::Where('sr_no',$srno)
                        ->update(['status'=>$status]);

       }
      return redirect()->route('show_tickets');
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function modify(Request $request)
    {

      // print_r($request->input()); die();
         $status=$request->status;
          $srno=$request->id;

          $update=Ticket::Where('sr_no',$srno)
                        ->update(['status'=>$status]);

        return redirect()->route('show_tickets');

    }

    public function search($id)
    {
          $tickets=Ticket::where('sr_no',$id)->paginate(10);

          return view('ticket/tickets',compact('tickets'));
    }



    public function alerts(Request $request)
    {
        $input = $request;

       // print_r($input->input());

        $userdata=Userdetail::where('hub_id',$request->hub_id)->first();
        $user_id=$userdata->id;
        $user_name=$userdata->firstname;
        $user_mobile=$userdata->mobile;
        $user_location=$userdata->location;



        $hint='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $SR_NO='SYS'.substr(str_shuffle($hint), 0, 9);
       
        $ticket_data=Ticket::create([
                                    
                                     'subject'=>$input->subject,
                                     'status'=>'1',
                                     'user_id'=> $user_id,
                                     'hub_id'=>$input->hub_id,
                                     'pod_id'=>$input->pod_id,
                                     'threshold_value'=>$input->threshold,
                                     'current_value'=>$input->current_value,
                                     'sr_no'=>$SR_NO]);

         $ticket = new Ticket();

        $ticket->subject = $input->subject;
        $ticket->user_name = $user_name;
        $ticket->user_mobile = $user_mobile;
        $ticket->user_location = $user_location;
        $ticket->hub_id = $input->hub_id;
        $ticket->pod_id = $input->pod_id;
        $ticket->threshold_value = $input->threshold;
        $ticket->current_value = $input->current_value;   

       // Mail::to($userdata->email)->send(new TriggerEmail($ticket));

        /*$notification=new FirebaseNotificationController;

        $content = new Request
            ([
                'title'=>"Hydrolore",
                'body'=>$input->subject,
                   
            ]);

        $notification->show($content);*/

    }


    public function critical_alerts($Inputdata,$threshold , $date , $critical){

      $userdata=Userdetail::where('hub_id',$Inputdata['hub_id'])->first();
        $user_id=$userdata->id;
        $user_name=$userdata->firstname;
        $user_mobile=$userdata->mobile;
        $user_location=$userdata->location;
    
       $subject="";
       $current_value="";

        if($critical){
                foreach ($critical as $key => $value) {
                
                    $subject=$subject . "" .$key ." = ".$value." , " ;

                
                    if($key=="AB-T1"){
                        $subject="AB-T1 = "." ".$Inputdata['AB-T1'];
                        $subject=$subject.",".$this->validate_POD_T1($Inputdata,$threshold);
                   
                    }
                    
                }

        }
       
        $ticket = new Ticket();

        $ticket->subject = $subject;
        $ticket->user_name = $user_name;
        $ticket->user_mobile = $user_mobile;
        $ticket->user_location = $user_location;
        $ticket->hub_id = $Inputdata['hub_id'];
        $ticket->pod_id = $Inputdata['PODUID'];
       /* $ticket->threshold_value = $input->threshold;
        $ticket->current_value = $input->current_value;*/


         $checkalert=Ticket::where('subject',$subject)
                         ->where('pod_id',$Inputdata['PODUID'])
                          ->where('status','1')
                          ->where('created_at', 'like', $date.'%')
                          ->first();

            
        if(!$checkalert)
        {

        $hint='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $SR_NO='SYS'.substr(str_shuffle($hint), 0, 9);

        
        $ticket_data=Ticket::create([
                                    
                                     'subject'=>$subject,
                                     'status'=>'1',
                                     'user_id'=> $user_id,
                                     'hub_id'=>$Inputdata['hub_id'],
                                     'pod_id'=>$Inputdata['PODUID'],
                                     'threshold_value'=>"",
                                     'current_value'=>$subject,
                                     'sr_no'=>$SR_NO]);
            
            if($ticket_data)
            {
               // Mail::to($userdata->email)->send(new CriticalEmail($ticket));

            }

             
        }

       

    }

    public function validate_POD_T1($Inputdata , $threshold)
    {
      
         $thresholdValue=$threshold->POD_T1;

    
        if($Inputdata['POD-T1']>((int)$Inputdata['AB-T1']+$thresholdValue))
        {

        $subject='POD-T1 ='." ".$Inputdata['POD-T1']."";

         $subject=$subject.",".$this->validate_NUT_T1($Inputdata,$threshold);
 
         return $subject;

        }
       
       else
        {
          return "";
        }

    }

    public function validate_NUT_T1($Inputdata , $threshold)
    {
       // print_r($threshold);die();
         $thresholdValue=$threshold->POD_T1;

        

        if($Inputdata['NUT-T1']>((int)$Inputdata['POD-T1']+$thresholdValue))
        {

        $subject='NUT-T1 ='." ".$Inputdata['NUT-T1']."";

        return $subject;
        }
        else
        {
         
         return "";
        }
        

    }

  
}
