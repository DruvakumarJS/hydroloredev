<?php

namespace App\Http\Controllers\web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\Hub;
use App\Models\Pod;
use App\Models\Alert;
use App\Models\Userdetail;
use App\Models\Threshold;
use App\Models\MasterSyncData;


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

        //sensors data 
            $sensorsArray = array();
            $pods_array = array();
            $ab_array = array();
            $tds_array = array();
            $ph_array = array();

            $pods =  Pod::select('pod_id' , 'AB_T1' ,'TDS_V1' , 'PH_V1')->where('updated_at', 'LIKE', '%'.date('Y-m-d').'%')->get();
            foreach ($pods as $key => $value) {
                $pods_array[]=$value->pod_id;
                $ab_array[]=$value->AB_T1;
                $tds_array[]=$value->TDS_V1;
                $ph_array[]=$value->PH_V1;

            }

           // print_r(json_encode($ab_array) ); die();
            $sensorsArray = array('pods' => json_encode($pods_array) , 'ambian' => json_encode($ab_array) ,
                'tds' => json_encode($tds_array) , 'ph'=>json_encode($ph_array));

       //sensors data 

      //mean value data
            $olddate = date('Y-m-d',strtotime("-1 days")); 
            $mean_pods = array();
            $mean_day = array();
            $mean_night = array();
            $mean_values = array();

            $day_start = $olddate.' 06:00:00';
            $day_end = $olddate.' 17:59:59';

            $night_start = $olddate.' 18:00:00';
            $night_end = date('Y-m-d').' 05:59:59';

          $mean = MasterSyncData::select('pod_id')->where('created_at' , 'LIKE' , '%'.$olddate . '%')->groupBy('pod_id')->get();
          foreach ($mean as $key => $value) {
            $mean_pods[]=$value->pod_id;

            $mean_day[] = MasterSyncData::where('pod_id',$value->pod_id)->whereBetween('created_at' , [$day_start, $day_end])->avg('AB_T1');

             $mean_night[] = MasterSyncData::where('pod_id',$value->pod_id)->whereBetween('created_at' , [$night_start, $night_end])->avg('AB_T1');

              
          }

          $mean_values= array('mean_pods' => json_encode($mean_pods), 'mean_day'=>json_encode($mean_day) , 'mean_night' =>json_encode($mean_night) );

           /*print_r($mean_pods);
           print_r('<br>');
           print_r($mean_day);
           print_r('<br>');
           print_r($mean_night);
           die();*/


      //mean value data      
        
    
    $date = date('Y-m-d');
       $tickets=Ticket::where('status','!=','0')
                        ->where('created_at','LIKE','%'.$date.'%')->paginate(10);

         return view('home',compact('tickets', 'pods_count' ,'hub_count','alert_count','tickets_count', 'users_xValue', 'users_yValue','tickets_xValue', 'tickets_yValue' , 'tickets_closed_yValue' , 'sensorsArray' , 'mean_values'));
         
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
