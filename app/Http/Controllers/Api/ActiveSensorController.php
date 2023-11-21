<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MasterSyncData;
use App\Models\SensorNotification;
use App\Models\Threshold;
class ActiveSensorController extends Controller
{
    public function sensor_details($id){
       /*$pod_id = $request->pod_id;
       $user_id = $request->user_id;*/
       $data = array();
       $solution = array();
       $sesors_status = array();

       if(MasterSyncData::where('pod_id', $id)->orderBy('id' , 'DESC')->exists()){
       	 $sensor_data = MasterSyncData::where('pod_id', $id)->orderBy('id' , 'DESC')->first();
       	 $threshold = Threshold::where('pod_id', $id)->first();
         
         $th_ambian = $threshold->AB_T1 ;
         
    //AB_T1
        /* if($sensor_data->AB_T1>$th_ambian)
         {
            if(SensorNotification::where('sensor_key' , 'AB_T1')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'AB_T1')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }
             
             $sesors_status[]=[
             	'sensor' => 'Ambian Temparature' ,
             	'detail' => 'This sensor will check the Ambian Temparature',
             	'status' => 'Faulty',
             	'file_directory'=> url('/').'/sensors/',
             	'filename'=> 'temperature.svg',
                'solution' => $solution
              ];
         }
         else{
         	$sesors_status[]=[
             	'sensor' => 'Ambian Temparature' ,
             	'detail' => 'This sensor will check the Ambian Temparature',
             	'status' => 'Okey',
             	'file_directory'=> url('/').'/sensors/',
             	'filename'=> '',
                'solution' => $solution
              ];

         }*/

    //POD_T1 
         $th_pod = $threshold->POD_T1 ;
         $solution = array();
         
         $val = intval($sensor_data->AB_T1)+intval($th_pod);

         if($sensor_data->POD_T1>$val)
         {
             
               if(SensorNotification::where('sensor_key' , 'POD_T1')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'POD_T1')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }
             
             $sesors_status[]=[
             	'sensor' => 'POD Temparature' ,
             	'detail' => 'This sensor will check the POD/BB Temparature',
             	'status' => 'Faulty',
             	'file_directory'=> url('/').'/sensors/',
             	'filename'=> 'temperature.svg',
                'param'=>'POD_T1',
                'solution' => $solution
              ];
         }
         else{
         	$sesors_status[]=[
             	'sensor' => 'POD Temparature' ,
             	'detail' => 'This sensor will check the POD/BB Temparature',
             	'status' => 'Okey',
             	'file_directory'=> url('/').'/sensors/',
             	'filename'=> 'temperature.svg',
                'param'=>'POD_T1',
                'solution' => $solution
              ];

         }

    //TDS
        /* $th_tds = $threshold->TDS_V1 ;
         $solution = array();
        
         if($sensor_data->TDS_V1>$th_tds)
         {
            if(SensorNotification::where('sensor_key' , 'TDS_V1')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'TDS_V1')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }
             
             $sesors_status[]=[
             	'sensor' => 'TDS value' ,
             	'detail' => 'This shows total Dissolved Salt Sensor value',
             	'status' => 'Faulty',
             	'file_directory'=> url('/').'/sensors/',
             	'filename'=> 'temperature.svg',
                'solution' => $solution
              ];
         }
         else{
         	$sesors_status[]=[
             	'sensor' => 'TDS value' ,
             	'detail' => 'This shows total Dissolved Salt Sensor value',
             	'status' => 'Okey',
             	'file_directory'=> url('/').'/sensors/',
             	'filename'=> 'temperature.svg',
                'solution' => $solution
              ];

         }
    //PH
          $th_ph = $threshold->PH_V1 ;
          $solution = array();    

         if($sensor_data->PH_V1>$th_ph)
         {
            if(SensorNotification::where('sensor_key' , 'PH_V1')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'PH_V1')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }
             
             $sesors_status[]=[
             	'sensor' => 'PH value' ,
             	'detail' => 'This measurs the pH value',
             	'status' => 'Faulty',
             	'file_directory'=> url('/').'/sensors/',
             	'filename'=> '',
                'solution' => $solution
              ];
         }
         else{
         	$sesors_status[]=[
             	'sensor' => 'PH value' ,
             	'detail' => 'This measurs the pH value',
             	'status' => 'Okey',
             	'file_directory'=> url('/').'/sensors/',
             	'filename'=> '',
                'solution' => $solution
              ];

         }
    
    // NP_I1
         $th_npi1=$threshold->NP_I1;
         $solution = array();
         $outputArr= preg_split("/[-:]/", $th_npi1);

         $min_np=trim($outputArr[0]);
         $max_np=trim($outputArr[1]);

         if($sensor_data->RL1=='ON')
         {
            
            if($sensor_data->NP_I1<$min_np || $sensor_data->NP_I1>$max_np)
            {
                if(SensorNotification::where('sensor_key' , 'NP_I1')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'NP_I1')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }
              $sesors_status[]=[
                'sensor' => 'Current (Consumed) - Nutrition Pump' ,
                'detail' => 'This Captures the Nutrition pump current in mA',
                'status' => 'Faulty',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> 'nutrition.svg',
                'solution' => $solution
              ];
            }
            else {
                $sesors_status[]=[
                'sensor' => 'Current (Consumed) - Nutrition Pump' ,
                'detail' => 'This Captures the Nutrition pump current in mA',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> 'nutrition.svg',
                'solution' => $solution
              ];

            }
         }
         else {
                $sesors_status[]=[
                'sensor' => 'Current (Consumed) - Nutrition Pump' ,
                'detail' => 'This Captures the Nutrition pump current in mA',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> 'nutrition.svg',
                'solution' => $solution
              ];

            }

     // NP_I1
         $th_svi1=$threshold->SV_I1;
         $solution = array();
         $outputArr= preg_split("/[-:]/", $th_svi1);

         $min_sv=trim($outputArr[0]);
         $max_sv=trim($outputArr[1]);

        if($sensor_data->RL3=='ON')
        {

            if($sensor_data->SV_I1<$min_sv || $sensor_data->SV_I1>$max_sv)
            {
                if(SensorNotification::where('sensor_key' , 'SV_I1')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'SV_I1')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }
              $sesors_status[]=[
                'sensor' => 'Current (Consumed) - Solenoid ' ,
                'detail' => 'This Captures the Solenoid current in mA',
                'status' => 'Faulty',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> 'solenoid.svg',
                'solution' => $solution
              ];
            }
            else {
                $sesors_status[]=[
                'sensor' => 'Current (Consumed) - Solenoid ' ,
                'detail' => 'This Captures the Nutrition pump current in mA',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> 'solenoid.svg',
                'solution' => $solution
              ];

            }
        }
        else {
                $sesors_status[]=[
                'sensor' => 'Current (Consumed) - Solenoid ' ,
                'detail' => 'This Captures the Nutrition pump current in mA',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> 'solenoid.svg',
                'solution' => $solution
              ];

            }
            */
      // STS_NP1

        $th_sts=$threshold->STS_NP1;
        $solution = array();
        $outputArr= preg_split("/[-:]/", $th_sts);
       
        $threshold_time= "-".trim($outputArr[1])."minutes";
        $val = ltrim($threshold_time, '-');
       
        $before_hour=date('Y-m-d H:i:s',strtotime($threshold_time));
       // print_r($before_hour) ; 

        $trigger='true';

        /*if(MasterSyncData::where('created_at','>',$before_hour)->where('pod_id',$id)->exists()) 
        { 
            $prev_data=MasterSyncData::where('created_at','>',$before_hour)->where('pod_id',$id)->get();

           // print_r(json_encode($prev_data));

            foreach ($prev_data as $key => $value) {
            
               if(($value->WL2H)!='FLT' ){
                       
                       $trigger='false';

               }
               
            }
        }
        else{
          // print_r("ttt");
            $trigger='false';
        }*/

        if($sensor_data->STS_NP1 == 'FLT'){
            $trigger='true';
        }
        else{
            $trigger='false';
        }

      //  print_r($trigger); die();

        if($trigger == 'true'){
            if(SensorNotification::where('sensor_key' , 'STS_NP1')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'STS_NP1')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }
             $sesors_status[]=[
                'sensor' => 'Nutrient Pump Health' ,
                'detail' => 'This will check the health of the pump. OK or Faulty',
                'status' => 'Faulty',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> 'nutrition.svg',
                'solution' => $solution
              ];

        }
        else{
             $sesors_status[]=[
                'sensor' => 'Nutrient Pump Health' ,
                'detail' => 'This will check the health of the pump. OK or Faulty',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> 'nutrition.svg',
                'solution' => $solution
              ];

        }
 
    // STS_SV1

        $th_sv1=$threshold->STS_SV1;
        $solution = array();
        $outputArr1= preg_split("/[-:]/", $th_sv1);
       
        $threshold_time1= "-".trim($outputArr1[1])."minutes";
        $val1 = ltrim($threshold_time1, '-');
       
        $before_hour1=date('Y-m-d H:i:s',strtotime($threshold_time1));

        $trigger1='true';

       
       // print_r($before_hour1);die();
       /* if(MasterSyncData::where('created_at','>',$before_hour1)->where('pod_id',$id)->exists()) 
        { 
            $prev_data1=MasterSyncData::where('created_at','>',$before_hour1)->where('pod_id',$id)->get();

            foreach ($prev_data1 as $key => $value) {
               
               if(($value->WL3H)!='FLT'){
                       
                       $trigger='false';

               }
            }
        }
        else{
           
            $trigger='false';
        }*/

        if($sensor_data->STS_SV1 == 'FLT'){
            $trigger='true';
        }
        else{
            $trigger='false';
        }

        

        if($trigger == 'true'){
            if(SensorNotification::where('sensor_key' , 'STS_SV1')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'STS_SV1')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }
             $sesors_status[]=[
                'sensor' => 'Fresh Water Solenoid Valve ' ,
                'detail' => 'This will check if the fresh water outlet is working  as needed.',
                'status' => 'Faulty',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> 'solenoid.svg',
                'solution' => $solution
              ];

        }
        else{
             $sesors_status[]=[
                'sensor' => 'Fresh Water Solenoid Valve ' ,
                'detail' => 'This will check if the fresh water outlet is working  as needed.',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> 'solenoid.svg',
                'solution' => $solution
              ];

        }

    // WL1L

       /* $th_wl1l=$threshold->WL1L;
        $solution = array();
        $outputArr2= preg_split("/[-:]/", $th_wl1l);
       
        $threshold_time2= "-".trim($outputArr2[1])."minutes";
        $val2 = ltrim($threshold_time2, '-');
       
        $before_hour2=date('Y-m-d H:i:s',strtotime($threshold_time2));

        

        $trigger2='true';

        if($sensor_data->WL1L=='OFF') 
            {
            if(MasterSyncData::where('created_at','>',$before_hour2)->where('pod_id',$id)->exists()) 
            {   

              $prev_data2=MasterSyncData::where('created_at','>',$before_hour2)->where('pod_id',$id)->get();

                if($prev_data2->count()>1)
                { 
       
                    foreach ($prev_data2 as $key => $value) {
                       
                       if(($value->WL1L)!='OFF'){
                               
                               $trigger='false';
                       }
                    }
                }
                else{
   
                      $trigger='false';
                }
            }
            else{
                $trigger='false';
            }

            if($trigger == 'true'){
                if(SensorNotification::where('sensor_key' , 'WL1L')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'WL1L')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }
             $sesors_status[]=[
                'sensor' => 'Low Level Source Tank -1' ,
                'detail' => 'This is the status of Source Tank Water Level Sensor-1 - Low Level ',
                'status' => 'Faulty',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];

        }
        else{
             $sesors_status[]=[
                'sensor' => 'Low Level Source Tank -1' ,
                'detail' => 'This is the status of Source Tank Water Level Sensor-1 - Low Level ',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];

        }


         }
         else {

             $sesors_status[]=[
                'sensor' => 'Low Level Source Tank -1' ,
                'detail' => 'This is the status of Source Tank Water Level Sensor-1 - Low Level ',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];

         }

    
    // WL2L

        $th_wl2l=$threshold->WL2L;
        $solution = array();
        $outputArr3= preg_split("/[-:]/", $th_wl2l);
       
        $threshold_time3= "-".trim($outputArr3[1])."minutes";
        $val3 = ltrim($threshold_time3, '-');
       
        $before_hour3=date('Y-m-d H:i:s',strtotime($threshold_time3));

        $trigger3='true';

        if($sensor_data->WL2L=='OFF') 
            {
            if(MasterSyncData::where('created_at','>',$before_hour3)->where('pod_id',$id)->exists()) 
            {   
              $prev_data3=MasterSyncData::where('created_at','>',$before_hour3)->where('pod_id',$id)->get();

                if($prev_data3->count()>1)
                {                            
                    foreach ($prev_data3 as $key => $value) {
                       
                       if(($value->WL2L)!='OFF'){
                               
                               $trigger='false';
                       }
                    }
                }
                else{

                      $trigger='false';
                }
            }
            else{
               
                $trigger='false';
            }

            if($trigger == 'true'){
                if(SensorNotification::where('sensor_key' , 'WL2L')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'WL2L')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }
             $sesors_status[]=[
                'sensor' => 'Low Level Reservoir Tank -2' ,
                'detail' => 'This is the status of Reservoir Tank Water Level Sensor-2 - Low Level ',
                'status' => 'Faulty',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];

        }
        else{
             $sesors_status[]=[
                'sensor' => 'Low Level Reservoir Tank -2' ,
                'detail' => 'This is the status of Reservoir Tank Water Level Sensor-2 - Low Level ',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];

        }


         }
         else {
             $sesors_status[]=[
                'sensor' => 'Low Level Reservoir Tank -2' ,
                'detail' => 'This is the status of Reservoir Tank Water Level Sensor-2 - Low Level ',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];

         }


    // WL3L

        $th_wl3l=$threshold->WL3L;
        $solution = array();
        $outputArr4= preg_split("/[-:]/", $th_wl3l);
       
        $threshold_time4= "-".trim($outputArr4[1])."minutes";
        $val4 = ltrim($threshold_time4, '-');
       
        $before_hour4=date('Y-m-d H:i:s',strtotime($threshold_time4));

        $trigger4='true';

        if($sensor_data->WL3L=='OFF') 
            {
            if(MasterSyncData::where('created_at','>',$before_hour4)->where('pod_id',$id)->exists()) 
            {   
              $prev_data4=MasterSyncData::where('created_at','>',$before_hour4)->where('pod_id',$id)->get();

                if($prev_data4->count()>1)
                {                            
                    foreach ($prev_data4 as $key => $value) {
                       
                       if(($value->WL3L)!='OFF'){
                               
                               $trigger='false';
                       }
                    }
                }
                else{

                      $trigger='false';
                }
            }
            else{
               
                $trigger='false';
            }

            if($trigger == 'true'){
                if(SensorNotification::where('sensor_key' , 'WL3L')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'WL3L')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }
             $sesors_status[]=[
                'sensor' => 'Low Level BackUP Tank -3' ,
                'detail' => 'This is the status of BackUP Tank Water Level Sensor-3 - Low Level ',
                'status' => 'Faulty',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];

        }
        else{
             $sesors_status[]=[
                'sensor' => 'Low Level BackUP Tank -3' ,
                'detail' => 'This is the status of BackUP Tank Water Level Sensor-3 - Low Level ',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];

        }


         }
         else {
             $sesors_status[]=[
                'sensor' => 'Low Level BackUP Tank -3' ,
                'detail' => 'This is the status of BackUP Tank Water Level Sensor-3 - Low Level ',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];

         } 

     // RL1
     
        $th_rl1=$threshold->RL1;
        $solution = array();
        $outputArr5= preg_split("/[-:]/", $th_rl1);
        $RL_ON='true';
        $RL_OFF='true';
        $on_time="-".trim($outputArr5[1])."minutes";
        $off_time="-".trim($outputArr5[2])."minutes";
         $on_interval=date('Y-m-d H:i:s',strtotime($on_time)); 
         $off_interval=date('Y-m-d H:i:s',strtotime($off_time));

           
            $prev_data=MasterSyncData::where('created_at','>',$on_interval)->where('pod_id',$id)->get();

            if($prev_data->count()>1 )
            {
            
            foreach ($prev_data as $key => $value) {
   
               if(($value->RL1)!='ON'){
                        
                       $RL_ON='false';
                       
               }
            }
            }
            else{
                $RL_ON='false';
            }
        

         $prev_data1=MasterSyncData::where('created_at','>',$off_interval)->where('pod_id',$id)->get();

            if($prev_data1->count()>1)
            {

            foreach ($prev_data1 as $key => $value) {
               
               if(($value->RL1)!='OFF'){
                       
                       $RL_OFF='false';
                       
               }
            }
            }

            else {
                 
                 $RL_OFF='false';

            }


            if($RL_ON=='true' || $RL_OFF=='true')
             {
                if(SensorNotification::where('sensor_key' , 'RL1')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'RL1')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }

                $sesors_status[]=[
                'sensor' => 'Relay - 1' ,
                'detail' => 'This Controls the Nutription Pump - 1',
                'status' => 'Faulty',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];
             }
            else{
                $sesors_status[]=[
                'sensor' => 'Relay - 1' ,
                'detail' => 'This Controls the Nutription Pump - 1',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];
             }

     // RL3
     
        $th_rl3=$threshold->RL3;
        $solution = array();
        $outputArr6= preg_split("/[-:]/", $th_rl3);
        $RL_ON='true';
        $RL_OFF='true';
        $on_time6="-".trim($outputArr6[1])."minutes";
        $off_time6="-".trim($outputArr6[2])."minutes";

         $on_interval6=date('Y-m-d H:i:s',strtotime($on_time6)); 
         $off_interval6=date('Y-m-d H:i:s',strtotime($off_time6));

        
            $prev_data6=MasterSyncData::where('created_at','>',$on_interval6)->where('pod_id',$id)->get();

            if($prev_data6->count()>1 )
            {

            foreach ($prev_data6 as $key => $value) {
   
               if(($value->RL3)!='ON'){
                       
                       $RL_ON='false';
                       
               }
            }
            }
            else{
                $RL_ON='false';
            }
        

         $prev_data66=MasterSyncData::where('created_at','>',$off_interval6)->where('pod_id',$id)->get();

            if($prev_data66->count()>1)
            {

            foreach ($prev_data66 as $key => $value) {
               
               if(($value->RL3)!='OFF'){
                       
                       $RL_OFF='false';
                       
               }
            }
            }

            else {
                 
                 $RL_OFF='false';

            }

            if($RL_ON=='true' || $RL_OFF=='true')
             {
                if(SensorNotification::where('sensor_key' , 'RL3')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'RL3')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }

                $sesors_status[]=[
                'sensor' => 'Relay - 3' ,
                'detail' => 'This Controls Fresh water Valve - 1',
                'status' => 'Faulty',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];
             }
            else{
                $sesors_status[]=[
                'sensor' => 'Relay - 3' ,
                'detail' => 'This Controls Fresh water Valve - 1',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];
             }        

     // RL4
     
        $th_rl4=$threshold->RL4;
        $solution = array();
        $outputArr7= preg_split("/[-:]/", $th_rl4);
        $RL_ON='true';
        $RL_OFF='true';
        $on_time7="-".trim($outputArr7[1])."minutes";
        $off_time7="-".trim($outputArr7[2])."minutes";
         $on_interval7=date('Y-m-d H:i:s',strtotime($on_time7)); 
         $off_interval7=date('Y-m-d H:i:s',strtotime($off_time7));

        
            $prev_data7=MasterSyncData::where('created_at','>',$on_interval7)->where('pod_id',$id)->get();

            if($prev_data7->count()>1)
            {

            foreach ($prev_data7 as $key => $value) {
   
               if(($value->RL4)!='ON'){
                       
                       $RL_ON='false';
                       
               }
            }
            }
            else{
                $RL_ON='false';
            }
        

         $prev_data77=MasterSyncData::where('created_at','>',$off_interval7)->where('pod_id',$id)->get();

            if($prev_data77->count()>1)
            {

            foreach ($prev_data77 as $key => $value) {
               
               if(($value->RL4)!='OFF'){
                       
                       $RL_OFF='false';
                       
               }
            }
            }

            else {
                 
                 $RL_OFF='false';

            }

            if($RL_ON=='true' || $RL_OFF=='true')
             {
                if(SensorNotification::where('sensor_key' , 'RL4')->exists()){
                  $solution = SensorNotification::where('sensor_key' ,'RL4')->where('type', 'Alert')->first();
                 
                  $solution = [
                    'tittle' => $solution->tittle ,
                    'issue' => $solution->issue ,
                    'description' => $solution->description ,
                    'solution' => $solution->solution ];

               }

                $sesors_status[]=[
                'sensor' => 'Relay - 4' ,
                'detail' => 'This Controls Fresh Water Valve – 2',
                'status' => 'Faulty',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];
             }
            else{
                $sesors_status[]=[
                'sensor' => 'Relay - 4' ,
                'detail' => 'This Controls Fresh Water Valve – 2',
                'status' => 'Okey',
                'file_directory'=> url('/').'/sensors/',
                'filename'=> '',
                'solution' => $solution
              ];
             }*/



        $data = $sesors_status;

        return response()->json([
		       'status' => '1',
		       'message' => 'Success',
		       'data'=>$data ]);
       }
       else {
       	 return response()->json([
		       'status' => '0',
		       'message' => 'No active sensor available',
		       'data'=>$data ]); 
       }
       


    }


    public function get_solution($param){
       $data = array();
       if(SensorNotification::where('sensor_key' , $param)->exists()){
          $solution = SensorNotification::where('sensor_key' , $param)->where('type', 'Alert')->first();
         
          $data = [
            ''];

       }
       else {
        return response()->json([
               'status' => '0',
               'message' => 'No solutions available ',
               'data'=>$data ]); 
       }
    }
}
