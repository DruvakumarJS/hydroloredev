<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pod;
use App\Models\PodMaster;
use App\Models\Threshold;
use App\Models\MasterSyncData;
use App\Exports\ExportPodHistory;
use App\Models\Ticket;
use App\Models\Userdetail;
use Illuminate\Support\Facades\Validator;
use Excel;
use App\Mail\PODstatusEmail;
use Mail;

class PODController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pods=Pod::paginate(50);

        return view('pod/pods',compact('pods'));
    }

    public function searchpod(Request $request , $id){

        $output="";
   
      $searchdata=Pod::where('pod_id','LIKE','%'.$request->search.'%')
                             
                             ->get();

      foreach ($searchdata as $key => $searchdata) 
      
          {
            $id=$key+1;
            $output.=

            '<tr> 
              <td> '.$id.'</td>
               <td> '.$searchdata->user->firstname.'</td>
              <td> '.$searchdata->hub_id.' </td>
              <td> '.$searchdata->pod_id.' </td>
              <td> '.$searchdata->location.' </td>
              <td> '.$searchdata->polyhouses.' </td>
              <td> '.$searchdata->created_at.' </td>
              <td> '.$searchdata->updated_at.' </td>
              <td> View History </td>
  
            </tr>';

          }                       

           

       return response($output);
    }

  

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchdata()
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
       
     // print_r($request->Input()); die();
       $validator = Validator::make($request->all(), [
            'pod_id' => 'required|unique:pods',
        ]);

        if ($validator->fails()) {

           return redirect()->back()->withMessage('The PODUID that you are trying to add is already linked to a HUB .');
                        
        }


        else if($request->action=='Add'){

         $data = $request->all();

       
        // $insert=Threshold::create($data);
       

      $Threshold =new Threshold();
        $Threshold->pod_id=$request->pod_id;
        $Threshold->hub_id=$request->hub_id;
        $Threshold->dimention=$request->dimention;
        $Threshold->status='active';
        $Threshold->location=$request->location;
        $Threshold->polyhouses=$request->polyhouses;
        $Threshold->user_id=$request->user_id;
        $Threshold->date=date('Y-m-d');
        $Threshold->date=date('H:i');
        $Threshold->AB_T1=$request->AB_T1;
       //$Threshold->AB_H1=$request->AB_H1;
        $Threshold->POD_T1=$request->POD_T1;
       // $Threshold->POD_H1=$request->POD_H1;
        $Threshold->TDS_V1=$request->min_TDS_V1."-".$request->max_TDS_V1;
        $Threshold->PH_V1=$request->min_PH_V1."-".$request->max_PH_V1;
        $Threshold->NUT_T1=$request->NUT_T1;
        $Threshold->NP_I1=$request->min_NP_I1."-".$request->max_NP_I1;
      //  $Threshold->NP_I2=$request->min_NP_I2."-".$request->max_NP_I2;
        $Threshold->SV_I1=$request->min_SV_I1."-".$request->max_SV_I1;
        //$Threshold->BAT_V1=$request->email;
        //$Threshold->FLO_V1=$request->FLO_UT;;
        //$Threshold->FLO_V2=$request->FLO_BT;
       // $Threshold->STS_PSU=$request->email;
        $Threshold->STS_NP1="OK"."-".$request->max_time_STS_NP1;
       // $Threshold->STS_NP2="OK"."-".$request->max_time_STS_NP2;
        $Threshold->STS_SV1="OK"."-".$request->max_time_STS_SV1;
       // $Threshold->STS_SV2="OK"."-".$request->max_time_STS_SV2;
       // $Threshold->WL1H=$request->WL1H;
        $Threshold->WL1L="ON"."-".$request->max_time_WL1L;
        //$Threshold->WL2H=$request->WL2H;
        $Threshold->WL2L="ON"."-".$request->max_time_WL2L;
       // $Threshold->WL3H=$request->WL3H;
        $Threshold->WL3L="ON"."-".$request->max_time_WL3L;
        $Threshold->RL1="OFF"."-".$request->min_time_RL1."-".$request->max_time_RL1;
        //$Threshold->RL2="OFF"."-".$request->min_time_RL2."-".$request->max_time_RL2;
        $Threshold->RL3="OFF"."-".$request->min_time_RL3."-".$request->max_time_RL3;
        $Threshold->RL4="OFF"."-".$request->min_time_RL4."-".$request->max_time_RL4;
       // $Threshold->RL5="OFF"."-".$request->min_time_RL8."-".$request->max_time_RL8;
        $Threshold->CUR=$request->CUR;
        $Threshold->PMODE=$request->PMODE;

        if($Threshold->save())
        {
              $create=Pod::insert(['pod_id' => $request->pod_id ,
                                'dimention' => $request->dimention,
                                'hub_id'=>$request->hub_id,
                                'status'=>'active',
                                'location'=>$request->location,
                                'dimention'=>$request->dimention,
                                'polyhouses' =>$request->polyhouses,
                                'user_id'=>$request->user_id,
                                "created_at" =>  \Carbon\Carbon::now(),
                                "updated_at" => \Carbon\Carbon::now(), 
                                 ]);
           
        }

       }
       return redirect()->route('view_user_details',$request->user_id);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $startdate="";
       $enddate=""; 
       $api_type=""; 
       $timearray=array();

       for ($i=00 ;$i<=22; $i++ ){
          if($i%2 == 0){
              if(strlen($i) == 1){
                $timearray[]='0'.$i;
              }
              else{
                 $timearray[]=$i;
              }
           
          }
       }

     //  print_r($timearray); die();

         $pods=MasterSyncData::where('pod_id',$id)->where('created_at','LIKE',date('Y-m-d').'%')->latest()->paginate(150);

         //temaparature data 
            $sensorsArray = array();
            $time_array = array();
            $ab_array = array();
            $pod_array = array();
            $nut_array = array();
            $tds_array = array();
            $phArray = array();

           
            /*$data = MasterSyncData::select('created_at','AB_T1','POD_T1','NUT_T1')->where('pod_id',$id)->where('created_at','LIKE',date('Y-m-d').'%')->orderBy('id', 'DESC')->skip(0)->take(12)->get();*/

            foreach ($timearray as $key=>$value) {
              $start_hour = $value.':00:01' ;

              $even_hour = intval(($value)+intval(1));

              if(strlen($even_hour) == 1){
                $even_hour= '0'.$even_hour;
              }
              $end_hour = $even_hour.':59:59' ;

               $ambian_avg = MasterSyncData::where('pod_id',$id)->whereBetween('created_at',[date('Y-m-d').' '.$start_hour , date('Y-m-d').' '.$end_hour])->orderBy('id', 'DESC')->avg('AB_T1');

                $pod_avg = MasterSyncData::where('pod_id',$id)->whereBetween('created_at',[date('Y-m-d').' '.$start_hour , date('Y-m-d').' '.$end_hour])->orderBy('id', 'DESC')->avg('POD_T1');

                $nut_avg = MasterSyncData::where('pod_id',$id)->whereBetween('created_at',[date('Y-m-d').' '.$start_hour , date('Y-m-d').' '.$end_hour])->orderBy('id', 'DESC')->avg('NUT_T1');

                $tds_avg = MasterSyncData::where('pod_id',$id)->whereBetween('created_at',[date('Y-m-d').' '.$start_hour , date('Y-m-d').' '.$end_hour])->orderBy('id', 'DESC')->avg('TDS_V1');

                $ph_avg = MasterSyncData::where('pod_id',$id)->whereBetween('created_at',[date('Y-m-d').' '.$start_hour , date('Y-m-d').' '.$end_hour])->orderBy('id', 'DESC')->avg('PH_V1');

              // print_r($start_hour);print_r(" "); print_r($Ambiam);print_r('<br>');
                $ab_array[]=$ambian_avg;
                $pod_array[]=$pod_avg;
                $nut_array[]=$nut_avg;
                $tds_array[]=$tds_avg;
                $ph_array[]=$ph_avg;
               
              }

            $sensorsArray = array('time' => json_encode($timearray) , 'ambian' => json_encode($ab_array) ,
                'pod' => json_encode($pod_array) , 'nut'=>json_encode($nut_array) , 'tds'=>json_encode($tds_array) ,'ph'=>json_encode(($ph_array)));


          //  print_r($sensorsArray); die();

       //Mean 
            $time= date('H:i');
            $olddate = date('Y-m-d',strtotime("-1 days")); 

           if($time >= '06:00' && $time < '17:59'){
           // print($olddate);
                $day_start = date('Y-m-d').' 06:00:00';
                $day_end =  date('Y-m-d').' 17:59:59';

                $night_start = $olddate.' 18:00:00';
                $night_end = date('Y-m-d').' 05:59:59';
               }
           else if($time >= '17:59' && $time < '23:59' ){
            // print("lll22222");
                $day_start = date('Y-m-d').' 06:00:00';
                $day_end =  date('Y-m-d').' 17:59:59';

                $night_start = date('Y-m-d').' 18:00:00';
                $night_end = date('Y-m-d').' 23:59:59';

           }
           else{
                $day_start = $olddate.' 06:00:00';
                $day_end =  $olddate.' 17:59:59';

                $night_start = $olddate.' 18:00:00';
                $night_end = date('Y-m-d').' 05:59:59';

           }
           
            $ab_day = MasterSyncData::where('pod_id',$id)->whereBetween('created_at' , [$day_start, $day_end])->avg('AB_T1');

            $ab_night = MasterSyncData::where('pod_id',$id)->whereBetween('created_at' , [$night_start, $night_end])->avg('AB_T1');

            $pod_day = MasterSyncData::where('pod_id',$id)->whereBetween('created_at' , [$day_start, $day_end])->avg('POD_T1');

            $pod_night = MasterSyncData::where('pod_id',$id)->whereBetween('created_at' , [$night_start, $night_end])->avg('POD_T1');

            $nut_day = MasterSyncData::where('pod_id',$id)->whereBetween('created_at' , [$day_start, $day_end])->avg('NUT_T1');

            $nut_night = MasterSyncData::where('pod_id',$id)->whereBetween('created_at' , [$night_start, $night_end])->avg('NUT_T1');
            

          $ambian_mean_values= array('mean_day'=>($ab_day) , 'mean_night' =>($ab_night) );
          $pod_mean_values= array('mean_day'=>($pod_day) , 'mean_night' =>($pod_night) );
          $nutri_mean_values= array('mean_day'=>($nut_day) , 'mean_night' =>($nut_night) );
            
       // Mean 
      // print_r($pod_mean_values);die(); 

        // switchs

          $tanks = MasterSyncData::select('WL1H' , 'WL1L' , 'WL2H' ,'WL2L')->where('pod_id', $id)->where('created_at','LIKE',date('Y-m-d').'%')->orderBy('id', 'DESC')->first();

         //  print_r(($sensorsArray));die();
        
         return view('pod/pod_sensors',compact('pods', 'id', 'startdate','enddate','api_type' , 'sensorsArray' , 'ambian_mean_values' , 'pod_mean_values' , 'nutri_mean_values' , 'tanks'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $pods=PodMaster::all();
        
         $users_details=Pod::where('pod_id',$id)->get();

         $threshold=Threshold::where('pod_id',$id)->first();

       //  print_r($threshold);die();


        return view('user/edit_pod',compact('pods' , 'threshold','users_details'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    

    if($request->action=='save'){

       // print_r($request->input());die();

      /*  unset($request['_token']);
        unset($request['action']);
       $input = $request->all();*/

    
       $update=Threshold::where('pod_id', $id)->update([
        'pod_id'=>$request->pod_id,
        'hub_id'=>$request->hub_id,
        'dimention'=>$request->dimention,
        'status'=>'active',
        'location'=>$request->location,
        'polyhouses'=>$request->polyhouses,
        'user_id'=>$request->user_id,
        'date'=>date('Y-m-d'),
        'time'=>date('H:i'),
        'AB_T1'=>$request->AB_T1,
        //'AB_H1'=>$request->AB_H1,
        'POD_T1'=>$request->POD_T1,
       // 'POD_H1'=>$request->POD_H1,
        'TDS_V1'=>$request->min_TDS_V1."-".$request->max_TDS_V1,
        'PH_V1'=>$request->min_PH_V1."-".$request->max_PH_V1,
        'NUT_T1'=>$request->NUT_T1,
        'NP_I1'=>$request->min_NP_I1."-".$request->max_NP_I1,
       // 'NP_I2'=>$request->min_NP_I2."-".$request->max_NP_I2,
        'SV_I1'=>$request->min_SV_I1."-".$request->max_SV_I1,
        //'BAT_V1'=>$request->email,
        //'FLO_V1'=>$request->FLO_UT,
        //'FLO_V2'=>$request->FLO_BT,
       // 'STS_PSU'=>$request->email,
        'STS_NP1'=>"OK"."-".$request->max_time_STS_NP1,
        //'STS_NP2'=>"OK"."-".$request->max_time_STS_NP2,
        'STS_SV1'=>"OK"."-".$request->max_time_STS_SV1,
        //'STS_SV2'=>"OK"."-".$request->max_time_STS_SV2,
       // 'WL1H'=>$request->WL1H,
        'WL1L'=>"ON"."-".$request->max_time_WL1L,
        //'WL2H'=>$request->WL2H,
        'WL2L'=>"ON"."-".$request->max_time_WL2L,
        //'WL3H'=>$request->WL3H,
        'WL3L'=>"ON"."-".$request->max_time_WL3L,
        'RL1'=>"OFF"."-".$request->min_time_RL1."-".$request->max_time_RL1,
        //'RL2'=>"OFF"."-".$request->min_time_RL2."-".$request->max_time_RL2,
        'RL3'=>"OFF"."-".$request->min_time_RL3."-".$request->max_time_RL3,
        'RL4'=>"OFF"."-".$request->min_time_RL4."-".$request->max_time_RL4,
        //'RL5'=>"OFF"."-".$request->min_time_RL8."-".$request->max_time_RL8,
       // 'PMODE'=>$request->PMODE,
        'CUR'=>$request->CUR]);
        

        if($update)
        {

             $update=Pod::where('pod_id', $id)
                             ->update(['location' => $request->location ,
                                     'dimention' => $request->dimention,
                                     'polyhouses' => $request->polyhouses    
                                 ]);
         }

     }
               

      return redirect()->route('view_user_details',$request->user_id);                    
         
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($podid)
    {
    
        $delete=Pod::where('pod_id',$podid)
         ->delete();

         $deleteThreshold = Threshold::where('pod_id',$podid)->delete();

         $deleteTickets = Ticket::where('pod_id',$podid)->delete();

         $deleteSyncData = MasterSyncData::where('pod_id',$podid)->delete();


          return redirect()->back();
                        
    }

    public function export(Request $request)
    {
      //  print_r($request->Input());die();
       
      
       $startdate="";
       $enddate=""; 
       

       $id=$request->pod_id;
       $datetimes=$request->dateselected;
       $api_type=$request->api_type;

       if(!empty($datetimes))
          {

            $range=preg_split("/[to:]/", $datetimes);

        
            $startdate=$range[0];
            $enddate=$range[2];
            
          }
         

       $file_name = 'pod'.$id.'_'.date('Y_m_d_H_i_s').'.csv';
       return Excel::download(new ExportPodHistory($id , $startdate , $enddate ,$api_type), $file_name);

      
     
    
    }

    public function filter(Request $request){

       $startdate="";
       $enddate=""; 
       $id=$request->pod_id;
       $api_type=$request->api_type;



       if(!empty($request->datetimes))
        {

        $range=preg_split("/[to:]/", $request->datetimes);

        $startdate=$range[0];
        $enddate=$range[2];

         
        }

       if($startdate=="" && $api_type=="none")
        {
        
         return redirect()->route('pod_history',$id);      

        }
        else if($startdate=="" && $api_type!="none")
        {
            $pods=MasterSyncData::where('pod_id',$id)
                 ->where('api_type',$api_type)
                 ->latest();
            $pods=$pods->paginate(50);        

        }
        else
        {

            if($api_type=="none"){
                $pods=MasterSyncData::where('pod_id',$id)
                 ->where('created_at','>=',$startdate.' 00:00:01')
                 ->where('created_at','<=',$enddate.' 23:59:59')
                 ->latest();
                 $pods=$pods->paginate(50); 
            }

            else
            {
                $pods=MasterSyncData::where('pod_id',$id)
                 ->where('created_at','>=',$startdate.' 00:00:01')
                 ->where('created_at','<=',$enddate.' 23:59:59')
                 ->where('api_type',$api_type)
                 ->latest();
                 $pods=$pods->paginate(50); 
            }
             
                  
        } 

        return view('pod/pod_history',compact('pods', 'id' , 'startdate','enddate' , 'api_type'));
        /* return redirect()->route('view_history/{id}')
                        ->withErrors($validator)
                        ->withInput();*/

    }


    public function history($id){
       $startdate="";
       $enddate=""; 
       $api_type=""; 

      $pods=MasterSyncData::where('pod_id',$id)->latest()->paginate(100);

      return view('pod/pod_history',compact('pods', 'id', 'startdate','enddate','api_type'));

    }
}
