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
      
      // print_r($request->input());die();
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
        if(isset($Inputdata['api_type'])){$syncdata->api_type=$Inputdata['api_type'];}

        
         $instant=json_encode($Inputdata['critical'],true);
        //print_r($instant);die();

        if(isset($Inputdata['critical'])){$syncdata->critical_data=$instant;}


      //   if(!isset($Inputdata['api_type']))
      //   {
      //        $add->api_type='Normal';  
      //   }
      //   else{
      //       $syncdata->api_type=$Inputdata['api_type'];
            
      //   }



     
      if($syncdata->save()){

           // print_r(array($syncdata));die();
            //print_r($syncdata->toArray());die();
            unset($syncdata['created_at']);
            unset($syncdata['updated_at']);
            unset($syncdata['api_type']);
            unset($syncdata['id']);
            unset($syncdata['critical_data']);
            unset($syncdata['hub_id']);

        
         $update=Pod::where('pod_id', $Inputdata['PODUID'])->update($syncdata->toArray());

         $threshold=Threshold::where('pod_id',$Inputdata['PODUID'])->first();

          $date=date('Y-m-d');

           
       /* if($Inputdata['api_type'] == "instant")
        {
       
             $critical=$Inputdata['critical'];  
            
             $threshold=Threshold::where('pod_id',$Inputdata['PODUID'])->first();

             $ticket_controller = new TicketsController;

             $ticket_controller->critical_alerts($Inputdata,$threshold , $date , $critical); 
        }*/
       /* else
        {*/
              
        
       // $this->validate_AB_T1($Inputdata, $threshold , $date );
        $this->validate_POD_T1($Inputdata, $threshold , $date ); 
        $this->validate_TDS_V1($Inputdata, $threshold , $date ); 
        $this->validate_PH_V1($Inputdata, $threshold , $date );  
        $this->validate_NUT_T1($Inputdata, $threshold , $date );           
        $this->validate_NP_I1($Inputdata, $threshold , $date );
       
        $this->validate_SV_I1($Inputdata, $threshold , $date );
       
        $this->validate_STS_NP1($Inputdata, $threshold , $date );
       
         $this->validate_STS_SV1($Inputdata, $threshold , $date );
         $this->validate_WL1L($Inputdata, $threshold , $date);
         $this->validate_WL2L($Inputdata, $threshold , $date); 
         $this->validate_WL3L($Inputdata, $threshold , $date);
         $this->validate_RL1($Inputdata, $threshold , $date);
        // $this->validate_RL2($Inputdata, $threshold , $date);
         $this->validate_RL3($Inputdata, $threshold , $date);
         $this->validate_RL4($Inputdata, $threshold , $date);

     
        //  }


         $threshold=Threshold::select('TDS_V1','PH_V1','NP_I1','SV_I1','RL1','RL3', 'RL4','CUR')->where('pod_id',$Inputdata['PODUID'])->first();
         $np_i1 = explode('-',$threshold->NP_I1);
         $SV_I1 = explode('-', $threshold->SV_I1);
         $rl1 = explode('-', $threshold->RL1);
         $rl3 = explode('-', $threshold->RL3);
         $rl4 = explode('-', $threshold->RL4);
         $tds = explode('-', $threshold->TDS_V1);
         $ph = explode('-', $threshold->PH_V1);

         $threshold_val = [];
         if($threshold){
                  $threshold_val= [
                     'TDS_V1_min' => $tds[0],
                     'TDS_V1_max' => $tds[1],
                     'PH_V1_min' => $ph[0],
                     'PH_V1_max' => $ph[1],
                     'NP_I1_min' => $np_i1[0],
                     'NP_I1_max' => $np_i1[1],
                     'SV_I1_min' => $SV_I1[0],
                     'SV_I1_max' => $SV_I1[1], 
                     'RL1_min' => $rl1[1],
                     'RL1_max' => $rl1[2],
                     'RL3_min' => $rl3[1],
                     'RL3_max' => $rl3[2],
                     'RL4_min' => $rl4[1],
                     'RL4_max' => $rl4[2],
                     'CUR' => $threshold->CUR
                  ];
         }

         

       
         return response()->json([
            'status'=>'success',
            'message'=>'Data inserted', 
           'threshold' => $threshold_val
         ]);
           
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
       // print_r("AB_T1");die();

        $thresholdValue=$threshold->AB_T1;
        /*$outputArr= preg_split("/[-:]/", $thresholdValue);

        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]); 
*/
        if($Inputdata['AB-T1']>$thresholdValue)
        {

        $subject='Ambient Temp is high';

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
                'current_value'=>$Inputdata['AB-T1'],
                'key'=> 'AB_T1 Should be below '.$thresholdValue,
                'api_type'=> 'normal',
                'is_critical_param' => '0'
                                            
            ]);
           $ticket_controller->alerts($content);
        } 
     
         }
    }

     public function validate_POD_T1($Inputdata ,$threshold , $date)
     {
      
        $thresholdValue=$threshold->POD_T1;

        /*$outputArr= preg_split("/[-:]/", $thresholdValue);

        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
            $x=trim($outputArr[2]);*/

       // print_r($min ." max".$max . " x".$x);die();

        
       $val = intval($Inputdata['AB-T1'])+intval($thresholdValue);
     
         if($Inputdata['POD-T1']>$val)
            {

             $subject='POD Temp is high';

           $checkalert=Ticket::where('subject',$subject)
                          ->where('pod_id',$Inputdata['PODUID'])
                          ->where('status','1')
                          ->where('created_at', 'like', $date.'%')
                          ->orderBy('id', 'DESC')->first();

                        

        if(!$checkalert)
        {
           // print_r("new"); die();

                $ticket_controller = new TicketsController; 
               
                $content = new Request
                    ([
                        'subject'=>$subject,
                        'hub_id'=>$Inputdata['hub_id'],
                        'pod_id'=>$Inputdata['PODUID'],
                        'threshold'=>$thresholdValue,
                        'current_value'=>$Inputdata['POD-T1'],
                        'key'=> 'Current Value is '.$Inputdata['POD-T1'].'. It needs be below '.$val,
                        'api_type'=> 'normal',
                        'is_critical_param' => '0'
                                                    
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
       

            if($Inputdata['TDS-V1']<$min || $Inputdata['TDS-V1']>$max)
            {

            $subject='Check TDS';

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
                            'current_value'=>$Inputdata['TDS-V1'],
                            'key'=> 'TDS currently is '.$Inputdata['TDS-V1']. '. It needs to be between '.$min.' & '.$max,
                            'api_type'=> 'normal',
                            'is_critical_param' => '1' 
                                                        
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
        // $x=trim($outputArr[2]);

            if($Inputdata['PH-V1']<$min || $Inputdata['PH-V1']>$max)
            {

            $subject='Check PH';

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
                            'current_value'=>$Inputdata['PH-V1'],
                            'key'=> 'pH currently is '.$Inputdata['PH-V1'].'. It needs to be between '.$min.' & '.$max,
                            'api_type'=> 'normal',
                            'is_critical_param' => '1' 
                                                        
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
             }
      }

     public function validate_NUT_T1($Inputdata ,$threshold , $date){
        
        $thresholdValue=$threshold->NUT_T1;

       /* $outputArr= preg_split("/[-:]/", $thresholdValue);

        $min=trim($outputArr[0]);
        $max=trim($outputArr[1]);
        $x=trim($outputArr[2]);*/
        
        $val = ((int)$Inputdata['POD-T1']+$thresholdValue) ;

         //if($Inputdata['NUT-T1']>((int)$Inputdata['POD-T1']+$thresholdValue))
        if($Inputdata['NUT-T1']<10 || $Inputdata['NUT-T1']>30)
                {

                $subject='Check Nutrient Temperature';


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
                        'current_value'=>$Inputdata['NUT-T1'],
                        'key'=> 'Nutrient Temp is '.$Inputdata['NUT-T1'].'. It needs to be between 10 & 30',
                        'api_type'=> 'normal',
                        'is_critical_param' => '0'
                                                            
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
        //$x=trim($outputArr[2]);

        if($Inputdata['RL1']=='ON')
        {

            if($Inputdata['NP-I1']<$min || $Inputdata['NP-I1']>$max)
            {

            $subject='NP Current Consumption';

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
                            'current_value'=>$Inputdata['NP-I1'],
                            'key'=> 'Relay 1 / NP Relay is ON and current consumption should be between min '.$min.' & '.$max.' mA. Current Value is '.$Inputdata['NP-I1'].' mA',
                            'api_type'=> 'normal',
                            'is_critical_param' => '1'

                                                        
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
        //$x=trim($outputArr[2]);

        if($Inputdata['RL3']=='ON')
        {

            if($Inputdata['SV-I1']<$min || $Inputdata['SV-I1']>$max)
            {

            $subject='SV Current Consumption';

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
                            'current_value'=>$Inputdata['SV-I1'],
                            'key'=> 'Relay 3 / SV Relay is ON and current consumption should be between min '.$min.' & '.$max.' mA. Current Value is '.$Inputdata['SV-I1'].' mA',
                            'api_type'=> 'normal',
                            'is_critical_param' => '1'
                                                        
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

      public function validate_STS_NP1($Inputdata ,$threshold , $date){
        $thresholdValue=$threshold->STS_NP1;
        $outputArr= preg_split('/[-:]/', $thresholdValue);
       
        $threshold_time= "-".trim($outputArr[1])."minutes";
        $val = ltrim($threshold_time, '-');

        $before_hour=date('Y-m-d H:i:s',strtotime($threshold_time));

        $trigger='false';

        if($Inputdata['STS-NP1'] == 'FLT'){
            $row_id = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->where('STS_NP1' , '!=', 'FLT')->max('id');
            $lastrow = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->max('id');

            if($row_id == $lastrow){
                $trigger = "false";
            }
            else{
                $trigger = "true";
            }
           
        }
         
        if($trigger=='true')
         {
            $error_id=$row_id+1;

            $data = MasterSyncData::where('id',$error_id)->first();

            $subject="NP Status is FLT";

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

             //          

                    if(!$checkalert)
                    {
                          
                        $ticket_controller = new TicketsController; 
                       
                        $content = new Request
                            ([
                                'subject'=>$subject,
                                'hub_id'=>$threshold['hub_id'],
                                'pod_id'=>$threshold['pod_id'],
                                'threshold'=>$thresholdValue,
                                'current_value'=>$Inputdata['STS-NP1'],
                                'key'=> 'NP Status is FLT since '.date('d M Y H:i',strtotime($data->created_at)),
                                'api_type'=> 'normal',
                                'is_critical_param' => '0'
                                                                        
                            ]);

                        $ticket_controller->alerts($content);
                  
                    }  
           
            }
        
        
      }

    public function validate_STS_SV1($Inputdata ,$threshold , $date){
        $thresholdValue=$threshold->STS_SV1;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        $threshold_time= "-".trim($outputArr[1])."minutes";
        $val = ltrim($threshold_time, '-');
       
        $before_hour=date('Y-m-d H:i:s',strtotime($threshold_time));

        $trigger='false';

        if($Inputdata['STS-SV1'] == 'FLT'){
            $row_id = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->where('STS_SV1' , '!=', 'FLT')->max('id');
            $lastrow = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->max('id');

            if($row_id == $lastrow){
                $trigger = "false";
            }
            else{
                $trigger = "true";
            }
           
        }
         
        if($trigger=='true')
         {
            $error_id=$row_id+1;

            $data = MasterSyncData::where('id',$error_id)->first();

            $subject="SV Status is FLT";

            $checkalert=Ticket::where('subject',$subject)
                             ->where('pod_id',$Inputdata['PODUID'])
                              ->where('status','1')
                              ->where('created_at', 'like', $date.'%')
                              ->orderBy('id', 'DESC')->first();

             //          

                    if(!$checkalert)
                    {
                          
                        $ticket_controller = new TicketsController; 
                       
                        $content = new Request
                            ([
                                'subject'=>$subject,
                                'hub_id'=>$threshold['hub_id'],
                                'pod_id'=>$threshold['pod_id'],
                                'threshold'=>$thresholdValue,
                                'current_value'=>$Inputdata['STS-NP1'],
                                'key'=> 'NP Status is FLT since '.date('d M Y H:i',strtotime($data->created_at)),
                                'api_type'=> 'normal',
                                'is_critical_param' => '0'
                                                                        
                            ]);

                        $ticket_controller->alerts($content);
                  
                    }  
           
            }
        
        
      }  

      public function validate_WL1L($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->WL1L;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        $threshold_time= "-".trim($outputArr[1])."minutes";
        $val = ltrim($threshold_time, '-');
       
        $before_hour=date('Y-m-d H:i:s',strtotime($threshold_time));

        $trigger='false';


        if($Inputdata['WL1L'] == 'OFF'){
            $row_id = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->where('WL1L' ,'!=','OFF')->max('id');
            $lastrow = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->max('id');

            if($row_id == $lastrow){
                $trigger = "false";
            }
            else{
                $error_id=$row_id+1;

                $data = MasterSyncData::where('id',$error_id)->first();

                $time_difference  = (strtotime(date('Y-m-d H:i:s'))-strtotime($data->created_at))/60; 
               // print_r($time_difference);
                if(intval($time_difference) > intval($outputArr[1])){

                    $trigger = "true";

                }
                else{
                    $trigger = "false";

                }



                
            }

        }
           // print_r($trigger); die();
  
            if($trigger=='true')
            {

          //  $subject="Source Tank Water Level Sensor-1 – Low Level Status issue";
             $subject="Upper Tank LL Sensor";

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
                            'current_value'=>$Inputdata['WL1L'],
                            'key' => "Upper Tank is empty for more than ".intval($time_difference)." minutes. The max time should be ".$val,
                            'api_type'=> 'normal',
                            'is_critical_param' => '0'
                                                                    
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
         
      
      } 

     public function validate_WL2L($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->WL2L;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        $threshold_time= "-".trim($outputArr[1])."minutes";
        $val = ltrim($threshold_time, '-');
       
        $before_hour=date('Y-m-d H:i:s',strtotime($threshold_time));

        $trigger='false';


        if($Inputdata['WL2L'] == 'OFF'){
            $row_id = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->where('WL2L' ,'!=','OFF')->max('id');
            $lastrow = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->max('id');

            if($row_id == $lastrow){
                $trigger = "false";
            }
            else{
                $error_id=$row_id+1;

                $data = MasterSyncData::where('id',$error_id)->first();

                $time_difference  = (strtotime(date('Y-m-d H:i:s'))-strtotime($data->created_at))/60; 
               // print_r($time_difference);
                if(intval($time_difference) > intval($outputArr[1])){

                    $trigger = "true";

                }
                else{
                    $trigger = "false";

                }
  
            }

        }
           // print_r($trigger); die();
  
            if($trigger=='true')
            {

          //  $subject="Source Tank Water Level Sensor-1 – Low Level Status issue";
             $subject="Lower Tank LL Sensor";

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
                            'current_value'=>$Inputdata['WL1L'],
                            'key' => "Lower Tank is empty for more than ".intval($time_difference)." minutes. The max time should be ".$val,
                            'api_type'=> 'normal',
                            'is_critical_param' => '0'
                                                                    
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
         
      
      } 

      public function validate_WL3L($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->WL3L;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        $threshold_time= "-".trim($outputArr[1])."minutes";
        $val = ltrim($threshold_time, '-');
       
        $before_hour=date('Y-m-d H:i:s',strtotime($threshold_time));

        $trigger='false';


        if($Inputdata['WL3L'] == 'OFF'){
            $row_id = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->where('WL3L' ,'!=','OFF')->max('id');
            $lastrow = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->max('id');

            if($row_id == $lastrow){
                $trigger = "false";
            }
            else{
                $error_id=$row_id+1;

                $data = MasterSyncData::where('id',$error_id)->first();

                $time_difference  = (strtotime(date('Y-m-d H:i:s'))-strtotime($data->created_at))/60; 
               // print_r($time_difference);
                if(intval($time_difference) > intval($outputArr[1])){

                    $trigger = "true";

                }
                else{
                    $trigger = "false";

                }
  
            }

        }
           // print_r($trigger); die();
  
            if($trigger=='true')
            {

          //  $subject="Source Tank Water Level Sensor-1 – Low Level Status issue";
             $subject="Back Up Tank LL Sensor";

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
                            'current_value'=>$Inputdata['WL1L'],
                            'key' => "Back Up Tank is empty for more than ".intval($time_difference)." minutes. The max time should be ".$val,
                            'api_type'=> 'normal',
                            'is_critical_param' => '0'
                                                                    
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
         
      
      } 


      public function validate_RL1($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->RL1;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        

        $RL_ON='false';
        $RL_OFF='false';

      
        $on_time="-".trim($outputArr[1])."minutes";
        $off_time="-".trim($outputArr[2])."minutes";

       
         $on_interval=date('Y-m-d H:i:s',strtotime($on_time)); 
         $off_interval=date('Y-m-d H:i:s',strtotime($off_time));

         if($Inputdata['RL1'] == 'ON'){
            $row_id = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->where('RL1' ,'!=','ON')->max('id');
            $lastrow = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->max('id');

            if($row_id == $lastrow){
                $RL_ON = "false";
            }
            else{
                $error_id=$row_id+1;

                $data = MasterSyncData::where('id',$error_id)->first();

                $time_difference  = (strtotime(date('Y-m-d H:i:s'))-strtotime($data->created_at))/60; 
               // print_r($time_difference);
                if(intval($time_difference) > intval($outputArr[1])){

                    $RL_ON = "true";

                }
                else{
                    $RL_ON = "false";

                }
  
            }


         }
         if($Inputdata['RL1'] == 'OFF'){
             $row_id = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->where('RL1' ,'!=','OFF')->max('id');
            $lastrow = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->max('id');

            if($row_id == $lastrow){
                $RL_OFF = "false";
            }
            else{
                $error_id=$row_id+1;

                $data = MasterSyncData::where('id',$error_id)->first();

                $time_difference  = (strtotime(date('Y-m-d H:i:s'))-strtotime($data->created_at))/60; 
               // print_r($time_difference);
                if(intval($time_difference) > intval($outputArr[2])){

                    $RL_OFF = "true";

                }
                else{
                    $RL_OFF = "false";

                }
  
            }

         }



            if($RL_ON=='true' || $RL_OFF=='true')
            {
               if($RL_ON=='true'){
                 $subject="NP Relay is ON Continously";
                 $key = "NP relay is ON for ".intval($time_difference)." mins. Should not be more  than ".ltrim($on_time , '-');
               }
               else if($RL_OFF=='true'){
                  $subject="NP Relay is OFF Continously";
                  $key = "NP relay is OFF for ".intval($time_difference)." mins. Should not be more  than ".ltrim($off_time , '-');
            }


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
                            'current_value'=>$Inputdata['RL1'],
                            'key' => $key,
                            'api_type'=> 'normal',
                            'is_critical_param' => '1'
                                                                    
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
       
      
      }

      public function validate_RL3($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->RL3;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        

        $RL_ON='false';
        $RL_OFF='false';

      
        $on_time="-".trim($outputArr[1])."minutes";
        $off_time="-".trim($outputArr[2])."minutes";

       
         $on_interval=date('Y-m-d H:i:s',strtotime($on_time)); 
         $off_interval=date('Y-m-d H:i:s',strtotime($off_time));

         if($Inputdata['RL3'] == 'ON'){
            $row_id = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->where('RL3' ,'!=','ON')->max('id');
            $lastrow = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->max('id');

            if($row_id == $lastrow){
                $RL_ON = "false";
            }
            else{
                $error_id=$row_id+1;

                $data = MasterSyncData::where('id',$error_id)->first();

                $time_difference  = (strtotime(date('Y-m-d H:i:s'))-strtotime($data->created_at))/60; 
               // print_r($time_difference);
                if(intval($time_difference) > intval($outputArr[1])){

                    $RL_ON = "true";

                }
                else{
                    $RL_ON = "false";

                }
  
            }


         }
         if($Inputdata['RL3'] == 'OFF'){
             $row_id = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->where('RL3' ,'!=','OFF')->max('id');
            $lastrow = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->max('id');

            if($row_id == $lastrow){
                $RL_OFF = "false";
            }
            else{
                $error_id=$row_id+1;

                $data = MasterSyncData::where('id',$error_id)->first();

                $time_difference  = (strtotime(date('Y-m-d H:i:s'))-strtotime($data->created_at))/60; 
               // print_r($time_difference);
                if(intval($time_difference) > intval($outputArr[2])){

                    $RL_OFF = "true";

                }
                else{
                    $RL_OFF = "false";

                }
  
            }

         }



            if($RL_ON=='true' || $RL_OFF=='true')
            {
               if($RL_ON=='true'){
                 $subject="SV Relay is OPEN Continously";
                 $key = "SV relay is OPEN for ".intval($time_difference)." mins. Should not be more  than ".ltrim($on_time , '-');
               }
               else if($RL_OFF=='true'){
                  $subject="SV Relay is CLOSED Continously";
                  $key = "SV relay is CLOSED for ".intval($time_difference)." mins. Should not be more  than ".ltrim($off_time , '-');
            }


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
                            'current_value'=>$Inputdata['RL3'],
                            'key' => $key,
                            'api_type'=> 'normal',
                            'is_critical_param' => '1'
                                                                    
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
       
      
      }

      public function validate_RL4($Inputdata ,$threshold , $date)
      {

        $thresholdValue=$threshold->RL4;
        $outputArr= preg_split("/[-:]/", $thresholdValue);
        

        $RL_ON='false';
        $RL_OFF='false';

      
        $on_time="-".trim($outputArr[1])."minutes";
        $off_time="-".trim($outputArr[2])."minutes";

       
         $on_interval=date('Y-m-d H:i:s',strtotime($on_time)); 
         $off_interval=date('Y-m-d H:i:s',strtotime($on_time));

         if($Inputdata['RL4'] == 'ON'){
            $row_id = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->where('RL4' ,'!=','ON')->max('id');
            $lastrow = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->max('id');

            if($row_id == $lastrow){
                $RL_ON = "false";
            }
            else{
                $error_id=$row_id+1;

                $data = MasterSyncData::where('id',$error_id)->first();

                $time_difference  = (strtotime(date('Y-m-d H:i:s'))-strtotime($data->created_at))/60; 
               // print_r($time_difference);
                if(intval($time_difference) > intval($outputArr[1])){

                    $RL_ON = "true";

                }
                else{
                    $RL_ON = "false";

                }
  
            }


         }
         if($Inputdata['RL4'] == 'OFF'){
             $row_id = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->where('RL4' ,'!=','OFF')->max('id');
            $lastrow = MasterSyncData::where('pod_id',$Inputdata['PODUID'])->max('id');

            if($row_id == $lastrow){
                $RL_OFF = "false";
            }
            else{
                $error_id=$row_id+1;

                $data = MasterSyncData::where('id',$error_id)->first();

                $time_difference  = (strtotime(date('Y-m-d H:i:s'))-strtotime($data->created_at))/60; 
               // print_r($time_difference);
                if(intval($time_difference) > intval($outputArr[2])){

                    $RL_OFF = "true";

                }
                else{
                    $RL_OFF = "false";

                }
  
            }

         }



            if($RL_ON=='true' || $RL_OFF=='true')
            {
               if($RL_ON=='true'){
                 $subject="Back UP SV Relay is ON continously";
                 $key = "Back Up Tank SV relay is ON for ".intval($time_difference)." mins. Should not be more  than ".ltrim($on_time , '-');
               }
               else if($RL_OFF=='true'){
                  $subject="Back Up SV Relay is OFF continously";
                  $key = "Back Up Tank SV relay is OFF for ".intval($time_difference)." mins. Should not be more  than ".ltrim($off_time , '-');
            }


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
                            'current_value'=>$Inputdata['RL4'],
                            'key' => $key,
                            'api_type'=> 'normal',
                            'is_critical_param' => '1'
                                                                    
                        ]);


                   $ticket_controller->alerts($content);
                    }  
           
            }
       
      
      }
  
      public function getThresholdData($podid){
          
         $threshold = Threshold::where('pod_id','=', $podid)->get();
         if($threshold){
            return [
               'status' => 'Success',
               'data' => $threshold
            ];
         }
         return [
            'status' => 'Failed',
            'message' => 'No Data Found'
         ];

      }      
             
} 
