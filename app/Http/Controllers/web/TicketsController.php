<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Threshold;
use Illuminate\Support\Facades\Validator;
use App\Models\Userdetail;
use App\Models\Questions;
use Illuminate\Support\Facades\Mail;
use App\Mail\TriggerEmail;
use App\Mail\CriticalEmail;
use App\Mail\GenerateTicket;
use DB;
use App\Models\Pod;
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
       // print_r($request->Input()); die();
      if(!isset($request->search) && isset($request->id)){
             $tickets=Ticket::where('user_id', $request->id)->paginate(25);
        }

        else if(!empty($request->search) && empty($request->id))
        {
            $status="";
            if($request->search=='closed')
            {
                $status="0";
            }
            elseif($request->search=='pending')
            {
                $status="2";
            }
            elseif($request->search=='open')
            {
                $status="1";
            }
         
               $tickets=Ticket::
                              Where('sr_no','LIKE','%'.$request->search.'%')
                            ->orWhere('subject','LIKE','%'.$request->search.'%')
                            ->orWhere('status',$status)
                            ->orWhere('pod_id','LIKE','%'.$request->search.'%')
                            ->orWhere('created_at','LIKE','%'.$request->search.'%')
                            ->orderByRaw('FIELD(status , "1" , "2" ,"0")')
                            ->orderBy('created_at','DESC')
                            ->paginate(25);



        }
        else if(!empty($request->search) && !empty($request->id)){
            
            $status="";
            if($request->search=='closed')
            {
                $status="0";
            }
            elseif($request->search=='pending')
            {
                $status="2";
            }
            elseif($request->search=='open')
            {
                $status="1";
            }
             $id = $request->id;
             $search = $request->search;

             $tickets=Ticket::where('user_id',$id)
                             ->where(function($q) use ($search , $status) {
                                 $q->where('sr_no','LIKE','%'.$search.'%')
                                    ->orWhere('subject','LIKE','%'.$search.'%')
                            ->orWhere('status',$status)
                            ->orWhere('pod_id','LIKE','%'.$search.'%')
                            ->orWhere('created_at','LIKE','%'.$search.'%')
                            ->orderByRaw('FIELD(status , "1" , "2" ,"0")')
                            ->orderBy('created_at','DESC');
                             })->paginate(25);
         
              /* $tickets=Ticket::where(function($query) use ($id) {
                                $query->where('user_id',$id);
                            })
                            ->orWhere('sr_no','LIKE','%'.$request->search.'%')
                            ->orWhere('subject','LIKE','%'.$request->search.'%')
                            ->orWhere('status',$status)
                            ->orWhere('pod_id','LIKE','%'.$request->search.'%')
                            ->orWhere('created_at','LIKE','%'.$request->search.'%')
                            ->orderByRaw('FIELD(status , "1" , "2" ,"0")')
                            ->orderBy('created_at','DESC')
                           
                            ->paginate(25);*/
        }

        else
        {
          
            $tickets=Ticket::
            orderByRaw('FIELD(status , "1" , "2" ,"0")')
            ->orderBy('created_at','DESC')
            ->paginate(25);

        }
       
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
            
            'email_id' => 'required|email',
            
        ]);


       if ($validator->fails()) {
            return redirect()->route('redirect_add_tickets')
                        ->withErrors($validator)
                        ->withInput();
        }


       $user=Userdetail::where('email',$request->email_id)->first();

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
         $t_id=Ticket::select('pod_id','id')->where('sr_no',$id)->first();
        $tickets=Ticket::where('id',$t_id->id)->first();
        $threshold = Threshold::where('pod_id',$t_id->pod_id)->first();
      //  print_r(json_encode($threshold)); die();
        
        return view('ticket/ticket_details',compact('id','tickets','threshold'));
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
   
      if($request->action =='Update'){

         $status=$request->status;
         $srno=$request->id;

         $update=Ticket::Where('sr_no',$srno)
                        ->update(['status'=>$status]);

      }
        

        return redirect()->route('show_tickets');

    }

    public function destroy($id){
        Ticket::Where('sr_no',$id)->delete();

        return redirect()->back();
    }

   /* public function search($id)
    {
          $tickets=Ticket::where('sr_no',$id)->paginate(10);

          return view('ticket/tickets',compact('tickets'));
    }*/



    public function alerts(Request $request)
    {
        $input = $request;

       // print_r($input->input());

       // $userdata=Userdetail::where('hub_id',$request->hub_id)->first();
        $userdata=Pod::where('pod_id',$request->pod_id)->first();
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
                                     'inputkeys'=>$request->key,
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
       $input_keys="";

        if($critical){
                foreach ($critical as $key => $value) {
                
                    $subject=$subject . "" .$key ." = ".$value." , " ;
                    $input_keys=$input_keys ."".$key." , ";

                
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
        $ticket->inputkeys = $input_keys;
       /* $ticket->threshold_value = $input->threshold;
        $ticket->current_value = $input->current_value;*/


         $checkalert=Ticket::where('inputkeys',$input_keys)
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
                                     'sr_no'=>$SR_NO ,
                                    'inputkeys'=>$input_keys]);
            
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
