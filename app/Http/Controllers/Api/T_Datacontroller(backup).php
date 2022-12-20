<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Pod;
use App\Models\Threshold;
use App\Models\Alert;
use App\Models\Ticket;
use App\Models\MasterSyncData;
use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\web\TicketsController;


class DataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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

       Storage::put('hub_data.txt', $request);

       $Inputdata=$request->input();


        $syncdata=new MasterSyncData();
        
      
        $syncdata->pod_id=$Inputdata['PODUID'];
        $syncdata->hub_id=$Inputdata['hub_id'];
        $syncdata->Date=$Inputdata['Date'];
        $syncdata->Time=$Inputdata['Time'];

        if(isset($Inputdata['AB-T1'])){$syncdata->AB_T1=$Inputdata['AB-T1'];}
        if(isset($Inputdata['AB-H1'])){$syncdata->AB_H1=$Inputdata['AB-H1'];}
        if(isset($Inputdata['POD-T1'])){$syncdata->POD_T1=$Inputdata['POD-T1'];}
        if(isset($Inputdata['POD-H1'])){$syncdata->POD_H1=$Inputdata['POD-H1'];}
        if(isset($Inputdata['TDS-V1'])){$syncdata->TDS_V1=$Inputdata['TDS-V1'];}
        if(isset($Inputdata['PH-V1'])){$syncdata->PH_V1=$Inputdata['PH-V1'];}
        if(isset($Inputdata['NUT-T1'])){$syncdata->NUT_T1=$Inputdata['NUT-T1'];}
        if(isset($Inputdata['NP-I1'])){$syncdata->NP_I1=$Inputdata['NP-I1'];}
        if(isset($Inputdata['SV-I1'])){$syncdata->SV_I1=$Inputdata['SV-I1'];}
        if(isset($Inputdata['BAT-V1'])){$syncdata->BAT_V1=$Inputdata['BAT-V1'];}
        if(isset($Inputdata['FLO-V1'])){$syncdata->FLO_V1=$Inputdata['FLO-V1'];}
        if(isset($Inputdata['FLO-V2'])){$syncdata->FLO_V2=$Inputdata['FLO-V2'];}
        if(isset($Inputdata['STS-PSU'])){$syncdata->STS_PSU=$Inputdata['STS-PSU'];}
        if(isset($Inputdata['STS-NP1'])){$syncdata->STS_NP1=$Inputdata['STS-NP1'];}
        if(isset($Inputdata['STS-NP2'])){$syncdata->STS_NP2=$Inputdata['STS-NP2'];}
        if(isset($Inputdata['STS-SV1'])){$syncdata->STS_SV1=$Inputdata['STS-SV1'];}
        if(isset($Inputdata['STS-SV2'])){$syncdata->STS_SV2=$Inputdata['STS-SV2'];}
        if(isset($Inputdata['WL1H'])){$syncdata->WL1H=$Inputdata['WL1H'];}
        if(isset($Inputdata['WL1L'])){$syncdata->WL1L=$Inputdata['WL1L'];}
        if(isset($Inputdata['WL2H'])){$syncdata->WL2H=$Inputdata['WL2H'];}
        if(isset($Inputdata['WL2L'])){$syncdata->WL2L=$Inputdata['WL2L'];}
        if(isset($Inputdata['WL3H'])){$syncdata->WL3H=$Inputdata['WL3H'];}
        if(isset($Inputdata['WL3L'])){$syncdata->WL3L=$Inputdata['WL3L'];}
        if(isset($Inputdata['RL1'])){$syncdata->RL1=$Inputdata['RL1'];}
        if(isset($Inputdata['RL2'])){$syncdata->RL2=$Inputdata['RL2'];}
        if(isset($Inputdata['RL3'])){$syncdata->RL3=$Inputdata['RL3'];}
        if(isset($Inputdata['RL4'])){$syncdata->RL4=$Inputdata['RL4'];}
        if(isset($Inputdata['RL5'])){$syncdata->RL5=$Inputdata['RL5'];}
        if(isset($Inputdata['PMODE'])){$syncdata->PMODE=$Inputdata['PMODE'];}

        if(!isset($Inputdata['api_type']))
        {
             $syncdata->api_type='Normal';  
        }
        else{
            $syncdata->api_type=$Inputdata['api_type'];
            
        }


         if($syncdata->save()){

           // print_r(array($syncdata));die();
            //print_r($syncdata->toArray());die();
            unset($syncdata['created_at']);
            unset($syncdata['updated_at']);
            unset($syncdata['api_type']);

        
         $update=Pod::where('pod_id', $Inputdata['PODUID'])->update($syncdata->toArray());

         $threshold=Threshold::where('pod_id',$Inputdata['PODUID'])->first();

          $date=date('Y-m-d');

           
        if(!empty($Inputdata['critical']))
        {
             $critical=$Inputdata['critical'];  
           
           $threshold=Threshold::where('pod_id',$Inputdata['PODUID'])->first();

             $ticket_controller = new TicketsController;

             $ticket_controller->critical_alerts($Inputdata,$threshold , $date , $critical); 
        }
        else
        {
          
          
         
        $this->validate_AB_T1($Inputdata, $threshold , $date );
        $this->validate_POD_T1($Inputdata, $threshold , $date ); 
         $this->validate_TDS_V1($Inputdata, $threshold , $date ); 
          $this->validate_PH_V1($Inputdata, $threshold , $date );  
        $this->validate_NUT_T1($Inputdata, $threshold , $date );           
        $this->validate_NP_I1($Inputdata, $threshold , $date );
       // $this->validate_NP_I2($Inputdata, $threshold , $date );
        $this->validate_SV_I1($Inputdata, $threshold , $date );
        $this->validate_FLO_UT($Inputdata, $threshold , $date );
        $this->validate_FLO_BT($Inputdata, $threshold , $date );
        $this->validate_STS_NP1($Inputdata, $threshold , $date );
        $this->validate_STS_NP2($Inputdata, $threshold , $date ); 
         $this->validate_STS_SV1($Inputdata, $threshold , $date );
         $this->validate_WL1L($Inputdata, $threshold , $date);
         $this->validate_WL2L($Inputdata, $threshold , $date); 
         $this->validate_RL1($Inputdata, $threshold , $date);
         $this->validate_RL2($Inputdata, $threshold , $date);
         $this->validate_RL3($Inputdata, $threshold , $date);

     
          }

         return response()->json([
            'status'=>'success',
            'message'=>'Data inserted', 
            'data'=>$request->input()]);
         }

         else 
         {
             return response()->json([
                'status' => 0,
                'message' => 'failed'
            ],200);

    }

     }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //  
    }

    public function validate_AB_T1($Inputdata ,$threshold , $date)
    {

        $thresholdValue=$threshold->AB_T1;
        $outputArr= preg_split("/[-:]/", $thresholdValue);

        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]); 

        if($Inputdata['AB-T1']>$max)
        {

        $subject='Ambient Temperature gone high';

        $checkalert=Ticket::where('subject',$subject)
                         ->where('pod_id',$Inputdata['PODUID'])
                          ->where('status','1')
                          ->where('created_at', 'like', $date.'%')
                          ->orderBy('id', 'DESC')->first();

                         

        if(!$checkalert)
        {
           $ticket_controller = new TicketsController; 
       
        $content = new Request
            ([
                'subject'=>$subject,
                'hub_id'=>$threshold['hub_id'],
                'pod_id'=>$threshold['pod_id'],
                'threshold'=>$thresholdValue,
                'current_value'=>$Inputdata['AB-T1']
                                            
            ]);


       $ticket_controller->alerts($content);
        } 


       
         }
    }

     public function validate_POD_T1($Inputdata ,$threshold , $date)
     {
        $thresholdValue=$threshold->POD_T1;

        $outputArr= preg_split("/[-:]/", $thresholdValue);

        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

       // print_r($min ." max".$max . " x".$x);die();


         if($Inputdata['POD-T1']>((int)$Inputdata['AB-T1']+$x))
            {

             $subject='POD/BB Temperature Sensor – 1 has issue';

           $checkalert=Ticket::where('subject',$subject)
                          ->where('pod_id',$Inputdata['PODUID'])
                          ->where('status','1')
                          ->where('created_at', 'like', $date.'%')
                          ->orderBy('id', 'DESC')->first();

                        

        if(!$checkalert)
        {

                $ticket_controller = new TicketsController; 
               
                $content = new Request
                    ([
                        'subject'=>$subject,
                        'hub_id'=>$Inputdata['hub_id'],
                        'pod_id'=>$Inputdata['PODUID'],
                        'threshold'=>$thresholdValue,
                        'current_value'=>$Inputdata['POD-T1']
                                                    
                    ]);


               $ticket_controller->alerts($content);
         }      

     }
     }

    public function validate_TDS_V1($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->TDS_V1;
        $outputArr= preg_split("/[-:]/", $thresholdValue);

        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

            if($Inputdata['TDS-V1']>$max)
            {

            $subject='Total Dissolved Salt Sensor issue';

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['TDS-V1']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
             }
      }

    
    public function validate_PH_V1($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->PH_V1;
        $outputArr= preg_split("/[-:]/", $thresholdValue);

        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

            if($Inputdata['PH-V1']>$max)
            {

            $subject='PH Sensor issue';

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['PH-V1']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
             }
      }

     public function validate_NUT_T1($Inputdata ,$threshold , $date){
        
        $thresholdValue=$threshold->NUT_T1;

        $outputArr= preg_split("/[-:]/", $thresholdValue);

        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);


         if($Inputdata['NUT-T1']>((int)$Inputdata['POD-T1']+$x))
                {

                $subject='Nutrient Solution Temperature Sensor Value – 1 has issue';


                 $checkalert=Ticket::where('subject',$subject)
                          ->where('pod_id',$Inputdata['PODUID'])
                          ->where('status','1')
                          ->where('created_at', 'like', $date.'%')
                          ->orderBy('id', 'DESC')->first();

                         

        if(!$checkalert)
        {

                $ticket_controller = new TicketsController; 
               
            
                $content = new Request
                    ([
                        'subject'=>$subject,
                        'hub_id'=>$Inputdata['hub_id'],
                        'pod_id'=>$Inputdata['PODUID'],
                        'threshold'=>$thresholdValue,
                        'current_value'=>$Inputdata['AB-T1']
                                                    
                    ]);


               $ticket_controller->alerts($content);

                 }   
        }   
     }

   
    public function validate_NP_I1($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->NP_I1;
        $outputArr= preg_split("/[-:]/", $thresholdValue);

        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

        if($Inputdata['RL1']=='ON')
        {

            if($Inputdata['NP-I1']<$min || $Inputdata['NP-I1']>$max)
            {

            $subject='Current (consumed) – Nutrient Pump 1 issue';

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['NP-I1']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
        }     
      }

   /* public function validate_NP_I2($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->NP_I2;
        $outputArr= preg_split("/[-:]/", $thresholdValue);

        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

        if($Inputdata['RL2']=='ON')
        {

            if($Inputdata['NP-I2']<$min || $Inputdata['NP-I2']>$max)
            {

            $subject='Current (consumed) – Nutrient Pump 2 issue';

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['NP-I2']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
             }
        }     
      } 
*/

    public function validate_SV_I1($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->SV_I1;
        $outputArr= preg_split("/[-:]/", $thresholdValue);

        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

        if($Inputdata['RL3']=='ON')
        {

            if($Inputdata['SV-I1']<$min || $Inputdata['SV-I1']>$max)
            {

            $subject='Current (consumed) – Solenoid Valve issue';

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['SV-I1']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
             }
        }     
      }  

    public function validate_FLO_UT($Inputdata ,$threshold , $date)
      {
      
      }

    public function validate_FLO_BT($Inputdata ,$threshold , $date)
      {
      
      }

    public function validate_STS_NP1($Inputdata ,$threshold , $date)
      {
        $thresholdValue=$threshold->STS_NP1;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        $before_hour=date('Y-m-d H:i:s',strtotime('-1 hour'));

        $trigger='true';


        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

        
            if($Inputdata['STS-NP1']=='FLT' && $Inputdata['STS-NP2']=='FLT')
            {

            $prev_data=MasterSyncData::where('created_at','>',$before_hour)->get();

            foreach ($prev_data as $key => $value) {
               
               if(($value->STS_NP1)!='FLT' ||  ($value->STS_NP2)!='FLT'){
                       
                       $trigger='false';
                       

               }
            }

           /* print_r("req time ".$before_hour);
            print_r($trigger);
*/
            if($trigger=='true')
            {


            $subject="Nutrient Pump Health Status – 1 issue";

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['STS-NP1']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
         }
        
      
      }
      
    public function validate_STS_NP2($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->STS_NP1;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        $before_hour=date('Y-m-d H:i:s',strtotime('-1 hour'));

        $trigger='true';


        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

        
            if($Inputdata['STS-NP1']=='FLT' && $Inputdata['STS-NP2']=='FLT')
            {

            $prev_data=MasterSyncData::where('created_at','>',$before_hour)->get();

            foreach ($prev_data as $key => $value) {
               
               if(($value->STS_NP1)!='FLT' ||  ($value->STS_NP2)!='FLT'){
                       
                       $trigger='false';
                       

               }
            }

            /*print_r("req time ".$before_hour);
            print_r($trigger);
*/
            if($trigger=='true')
            {


            $subject="Nutrient Pump Health Status – 2 issue";

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['STS-NP2']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
         }
      
      } 


    public function validate_STS_SV1($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->STS_SV1;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        $before_hour=date('Y-m-d H:i:s',strtotime('-1 hour'));

        $trigger='true';


        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

        
            if($Inputdata['STS-SV1']=='FLT' && $Inputdata['STS-SV2']=='FLT')
            {

            $prev_data=MasterSyncData::where('created_at','>',$before_hour)->get();

            foreach ($prev_data as $key => $value) {
               
               if(($value->STS_SV1)!='FLT' ||  ($value->STS_SV2)!='FLT'){
                       
                       $trigger='false';
                       

               }
            }

            /*print_r("req time ".$before_hour);
            print_r($trigger);
*/
            if($trigger=='true')
            {


            $subject="Fresh Water Solenoid Valve Health Status – 1 issue";

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['STS_SV1']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
         }
      
      } 

    public function validate_WL1L($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->WL1L;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        $before_hour=date('Y-m-d H:i:s',strtotime('-30 minutes'));

        $trigger='true';


        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

        
            if($Inputdata['WL1L']=='OFF')
            {

            $prev_data=MasterSyncData::where('created_at','>',$before_hour)->get();

            foreach ($prev_data as $key => $value) {
               
               if(($value->WL1L)!='OFF'){
                       
                       $trigger='false';
                       

               }
            }

          /*  print_r("req time ".$before_hour);
            print_r($trigger);die();*/

            if($trigger=='true')
            {


            $subject="Source Tank Water Level Sensor-1 – Low Level Status issue";

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['WL1L']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
         }
      
      } 

    public function validate_WL2L($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->WL2L;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        $before_hour=date('Y-m-d H:i:s',strtotime('-30 minutes'));

        $trigger='true';


        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

        
            if($Inputdata['WL2L']=='OFF')
            {

            $prev_data=MasterSyncData::where('created_at','>',$before_hour)->get();

            foreach ($prev_data as $key => $value) {
               
               if(($value->WL2L)!='OFF'){
                       
                       $trigger='false';
                       
                       
               }
            }

          /*  print_r("req time ".$before_hour);
            print_r($trigger);die();*/

            if($trigger=='true')
            {


            $subject="Source Tank Water Level Sensor-1 – Low Level Status issue";

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['WL2L']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
         }
      
      } 

    public function validate_RL1($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->RL1;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        //$before_hour=date('Y-m-d H:i:s',strtotime('-30 minutes'));

        $RL_ON='true';
        $RL_OFF='true';


        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

        $On_Off_hour= preg_split("[/]", $x);

        /* print_r($x);
         print_r($On_Off_hour);*/
         $on_interval=$On_Off_hour[0];
         $off_interval=$On_Off_hour[1];



        
            if($Inputdata['RL1']=='OFF')
            {

            $prev_data=MasterSyncData::where('created_at','>',$on_interval)->get();

            foreach ($prev_data as $key => $value) {

               
               if(($value->RL1)!='OFF'){
                       
                       $RL_ON='false';
                       
                       
               }
            }

             $prev_data=MasterSyncData::where('created_at','>',$off_interval)->get();

            foreach ($prev_data as $key => $value) {
               
               if(($value->RL1)!='OFF'){
                       
                       $RL_OFF='false';
                       
                       
               }
            }

          /*  print_r("req time ".$before_hour);
            print_r($trigger);die();*/

            if($RL_ON=='true' || $RL_OFF=='true')
            {


            $subject="Source Tank Water Level Sensor-1 – Low Level Status issue";

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['RL1']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
         }
      
      }


    public function validate_RL2($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->RL2;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
      

        $RL_ON='true';
        $RL_OFF='true';


        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

        $On_Off_hour= preg_split("[/]", $x);

        /* print_r($x);
         print_r($On_Off_hour);*/
         $on_interval=$On_Off_hour[0];
         $off_interval=$On_Off_hour[1];



        
            if($Inputdata['RL2']=='OFF')
            {

            $prev_data=MasterSyncData::where('created_at','>',$on_interval)->get();

            foreach ($prev_data as $key => $value) {
                
               
               if(($value->RL2)!='OFF'){
                       
                       $RL_ON='false';
                       
                       
               }
            }

             $prev_data=MasterSyncData::where('created_at','>',$off_interval)->get();

            foreach ($prev_data as $key => $value) {
               
               if(($value->RL2)!='OFF'){
                       
                       $RL_OFF='false';
                       
                       
               }
            }

          /*  print_r("req time ".$before_hour);
            print_r($trigger);die();*/

            if($RL_ON=='true' || $RL_OFF=='true')
            {


            $subject="Source Tank Water Level Sensor-1 – Low Level Status issue";

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['RL2']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
         }
      
      } 


    public function validate_RL3($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->RL3;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
      

        $RL_ON='true';
        $RL_OFF='true';


        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);

        $On_Off_hour= preg_split("[/]", $x);

        /* print_r($x);
         print_r($On_Off_hour);*/
         $on_interval=$On_Off_hour[0];
         $off_interval=$On_Off_hour[1];



        
            if($Inputdata['RL3']=='OFF')
            {

            $prev_data=MasterSyncData::where('created_at','>',$on_interval)->get();

            foreach ($prev_data as $key => $value) {
                
               
               if(($value->RL3)!='OFF'){
                       
                       $RL_ON='false';
                       
                       
               }
            }

             $prev_data=MasterSyncData::where('created_at','>',$off_interval)->get();

            foreach ($prev_data as $key => $value) {
               
               if(($value->RL3)!='OFF'){
                       
                       $RL_OFF='false';
                       
                       
               }
            }

          /*  print_r("req time ".$before_hour);
            print_r($trigger);die();*/

            if($RL_ON=='true' || $RL_OFF=='true')
            {


            $subject="Source Tank Water Level Sensor-1 – Low Level Status issue";

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

                             

                    if(!$checkalert)
                    {
                       $ticket_controller = new TicketsController; 
                   
                    $content = new Request
                        ([
                            'subject'=>$subject,
                            'hub_id'=>$threshold['hub_id'],
                            'pod_id'=>$threshold['pod_id'],
                            'threshold'=>$thresholdValue,
                            'current_value'=>$Inputdata['RL3']
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
         }
      
      }      


      public function sendalerts(){

      }          
             
}
