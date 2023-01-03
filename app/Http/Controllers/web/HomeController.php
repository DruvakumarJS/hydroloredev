<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Hub;
use App\Models\Pod;
use App\Models\Alert;
use App\Models\Userdetail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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
        $date=date('Y-m-d');
       
        
        $hubs=Hub::all();
        $hub_count=$hubs->count();

        $pods=Pod::all();
        $pods_count=$pods->count();

        $ticket=Ticket::all();
        $tickets_count=$ticket->count();
       
        $alerts=Alert::all();
        $alert_count=$alerts->count();


        $montharray=array();

        $month = date("t", strtotime('2021-10-18'));
        $alldatethismonth = range(1, $month);

        //users

        foreach($alldatethismonth as $date){
           
           if(strlen($date)==1){
             $today=date("Y-m-").'0'.$date;
           }
           else
           {
            $today=date("Y-m-").$date;
           }
           
            $user_count=Userdetail::where('created_at','LIKE','%'.$today.'%')->get();

            $results['y'][]=$user_count->count();
            $results['x'][]=$date;
           
        }

            $users_xValue = json_encode($results['x'], true);
            $users_yValue = json_encode($results['y'], true);
      
        //end


        //tickets
        foreach($alldatethismonth as $date){
           
           if(strlen($date)==1){
             $today=date("Y-m-").'0'.$date;
           }
           else
           {
            $today=date("Y-m-").$date;
           }
           
            $tckets_count=Ticket::where('created_at','LIKE','%'.$today.'%')->get();

            $result['y'][]=$tckets_count->count();
            $result['x'][]=$date;
           
        }

            $tickets_xValue = json_encode($result['x'], true);
            $tickets_yValue = json_encode($result['y'], true);

        //end  
        

         //tickets closed
        foreach($alldatethismonth as $date){
           
           if(strlen($date)==1){
             $today=date("Y-m-").'0'.$date;
           }
           else
           {
            $today=date("Y-m-").$date;
           }
           
            $tckets_closed_count=Ticket::where('updated_at','LIKE','%'.$today.'%')
            ->where('status',0)->get();

            $result_closed['y'][]=$tckets_closed_count->count();
            $result_closed['x'][]=$date;
           
        }

            $tickets_closed_xValue = json_encode($result_closed['x'], true);
            $tickets_closed_yValue = json_encode($result_closed['y'], true);

        //end    
        
    

       $tickets=Ticket::where('status','!=','0')
                        ->where('created_at','LIKE','%'.$date.'%')->paginate(10);



       // print_r($data);die();

         return view('home',compact('tickets', 'pods_count' ,'hub_count','alert_count','tickets_count', 'users_xValue', 'users_yValue','tickets_xValue', 'tickets_yValue' , 'tickets_closed_yValue'));
         
       }

    public function show()
    {

        print_r($date);exit();
       
    }
    public function destroy(){
         auth()->logout();
         return redirect()->route('login');
    }
}
