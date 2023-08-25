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
       $sesors_status = array();

       if(MasterSyncData::where('pod_id', $id)->orderBy('id' , 'DESC')->exists()){
       	 $sensor_data = MasterSyncData::where('pod_id', $id)->orderBy('id' , 'DESC')->first();
       	 $threshold = Threshold::where('pod_id', $id)->first();
         
         $th_ambian = $threshold->AB_T1 ;
         $th_pod = $threshold->POD_T1 ;
         $th_tds = $threshold->TDS_V1 ;
         $th_ph = $threshold->PH_V1 ;

         if($sensor_data->AB_T1>$th_ambian)
         {
             
             $sesors_status[]=[
             	'sensor' => 'Ambian Temparature' ,
             	'detail' => 'This sensor will check the Ambian Temparature',
             	'status' => 'Faulty',
             	'file_directory'=> url('/'),
             	'filename'=> ''
              ];
         }
         else{
         	$sesors_status[]=[
             	'sensor' => 'Ambian Temparature' ,
             	'detail' => 'This sensor will check the Ambian Temparature',
             	'status' => 'Okey',
             	'file_directory'=> url('/'),
             	'filename'=> ''
              ];

         }

         $val = intval($sensor_data->AB_T1)+intval($th_pod);

         if($sensor_data->POD_T1>$val)
         {
             
             $sesors_status[]=[
             	'sensor' => 'POD Temparature' ,
             	'detail' => 'This sensor will check the POD/BB Temparature',
             	'status' => 'Faulty',
             	'file_directory'=> url('/'),
             	'filename'=> ''
              ];
         }
         else{
         	$sesors_status[]=[
             	'sensor' => 'POD Temparature' ,
             	'detail' => 'This sensor will check the POD/BB Temparature',
             	'status' => 'Okey',
             	'file_directory'=> url('/'),
             	'filename'=> ''
              ];

         }

         if($sensor_data->TDS_V1>$th_tds)
         {
             
             $sesors_status[]=[
             	'sensor' => 'TDS value' ,
             	'detail' => 'This shows total Dissolved Salt Sensor value',
             	'status' => 'Faulty',
             	'file_directory'=> url('/'),
             	'filename'=> ''
              ];
         }
         else{
         	$sesors_status[]=[
             	'sensor' => 'TDS value' ,
             	'detail' => 'This shows total Dissolved Salt Sensor value',
             	'status' => 'Okey',
             	'file_directory'=> url('/'),
             	'filename'=> ''
              ];

         }

         if($sensor_data->PH_V1>$th_ph)
         {
             
             $sesors_status[]=[
             	'sensor' => 'PH value' ,
             	'detail' => 'This measurs the pH value',
             	'status' => 'Faulty',
             	'file_directory'=> url('/'),
             	'filename'=> ''
              ];
         }
         else{
         	$sesors_status[]=[
             	'sensor' => 'PH value' ,
             	'detail' => 'This measurs the pH value',
             	'status' => 'Okey',
             	'file_directory'=> url('/'),
             	'filename'=> ''
              ];

         }

         if($sensor_data->WL2H == 'FLT')
         {
             
             $sesors_status[]=[
             	'sensor' => 'Nutrition Pump' ,
             	'detail' => 'This will check the health of the pump.OK or Faulty',
             	'status' => 'Faulty',
             	'file_directory'=> url('/'),
             	'filename'=> ''
              ];
         }
         else{
         	$sesors_status[]=[
             	'sensor' => 'Nutrition Pump' ,
             	'detail' => 'This will check the health of the pump.OK or Faulty',
             	'status' => 'Okey',
             	'file_directory'=> url('/'),
             	'filename'=> ''
              ];

         }

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
}
