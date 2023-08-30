<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cultivation;
use App\Models\Crop;
use App\Models\GrowthDuration;
use App\Models\Activity;
use App\Models\Ticket;
use App\Models\SensorNotification;

class CropsController extends Controller
{
    public function mycrops(Request $request){
    	
    	$data = array();

    	if(isset($request->user_id) && isset($request->pod_id)){

            $count = 1;
            $channel_array=array();
            $channel_no_array= array();
            $sub_channel_array= array();
            $crops= array();
            
             while($count < 17){

                 $channel_array['channel_no']=$count;
                 $channel_array['sub_chanel']=array();

                 for ($i=1; $i < 4; $i++) { 
                    if($i == 1){$k = 'A';}
                    if($i == 2){$k = 'B';}
                    if($i == 3){$k = 'C';}
                     if(Cultivation::where('pod_id',$request->pod_id)->where('channel_no',$count)->where('sub_channel',$k)->exists()){
                       
                        $value= Cultivation::where('pod_id',$request->pod_id)->where('channel_no',$count)->where('sub_channel',$k)->first();
                        $crop_detail = Crop::where('id' , $value->crop_id)->first();
                        $crop_growth = GrowthDuration::where('crop_id',$value->crop_id)->where('category_id', $value->category_id)->first();

                        $planting_date = $value->planted_on ;
                        $today = date('Y-m-d');
                        $age = (strtotime($today)-strtotime($planting_date))/(60*60*24);

                        $seedling_day = $crop_growth->seedling;
                        $young = $crop_growth->young_plants;
                        $matured = $crop_growth->matured;
                        if($value->category_id == '5'){
                            $vegetative = $crop_growth->vegetative_phase;
                            $flowering = $crop_growth->flowering_stage;
                            $fruiting = $crop_growth->fruiting_stage;

                            $vegetative_range= preg_split("/[-:]/", $vegetative);
                            $vegetative_start = $vegetative_range[0];
                            $vegetative_end = $vegetative_range[1];

                            $flowering_range= preg_split("/[-:]/", $flowering);
                            $flowering_start = $flowering_range[0];
                            $flowering_end = $flowering_range[1];

                            $fruitingd_range= preg_split("/[-:]/", $fruiting);
                            $fruiting_start = $fruitingd_range[0];
                            $fruiting_end = $fruitingd_range[1];
                        }
                        else if($value->category_id != '5'){
                        $matured_range= preg_split("/[-:]/", $matured);
                        $matured_start = $matured_range[0];
                        $matured_end = $matured_range[1];

                        }
                        
                        $harvest = $crop_growth->harvesting ;

                        $seedling_range= preg_split("/[-:]/", $seedling_day);
                        $seedling_start = $seedling_range[0];
                        $seedling_end = $seedling_range[1];

                        $young_range= preg_split("/[-:]/", $young);
                        $young_start = $young_range[0];
                        $young_end = $young_range[1];

                        
                        $harvest_range= preg_split("/[-:]/", $harvest);
                        $harvest_start = $harvest_range[0];
                        $harvest_end = $harvest_range[1];
                       
                       if($value->category_id != '5'){
                        if($age < $seedling_start){
                            $current_stage = "Planted";

                        }

                        else if($age >= $seedling_start && $age < $young_start){
                              $current_stage = "Seedling";
                              $src =$crop_growth->seeding_image; 
                        }

                        else if($age >= $young_start && $age < $matured_start){
                              $current_stage = "Young Plants";
                              $src =$crop_growth->young_image;
                        }
                       else if($age >= $matured_start && $age < $harvest_start){
                              $current_stage = "Matured Plant";
                              $src =$crop_growth->matured_image;
                        }
                        else  if($age >= $harvest_start){
                             $current_stage = "Harvest";
                             $src =$crop_growth->harvesting_image;
                        }
                       }
                       else {
                          if($age < $seedling_start){
                            $current_stage = "Planted";

                        }

                        else if($age >= $seedling_start && $age < $young_start){
                              $current_stage = "Seedling";
                              $src =$crop_growth->seeding_image; 
                        }

                        else if($age >= $young_start && $age < $vegetative_start ){
                              $current_stage = "Young Plants";
                              $src =$crop_growth->young_image;
                        }
                       else if($age >= $vegetative_start && $age < $flowering_start){
                              $current_stage = "Vegitative Phase";
                              $src =$crop_growth->matured_image;
                        }

                        else if($age >= $flowering_start && $age < $fruiting_start){
                              $current_stage = "Flowering Stage";
                              $src =$crop_growth->matured_image;
                        }

                        else if($age >= $fruiting_start && $age < $harvest_start){
                              $current_stage = "Fruiting Stage";
                              $src =$crop_growth->matured_image;
                        }

                        else  if($age >= $harvest_start){
                             $current_stage = "Harvest";
                             $src = $crop_growth->harvesting_image;
                        }

                       } 
                   
                        
                        $harvest_date_range= preg_split("/[-:]/", $harvest);
                        $harvest_start_date = $harvest_date_range[0];
                        $harvest_date = date('Y-m-d', strtotime($planting_date . ' + '. $harvest_start_date . 'days'));

                        $days_remaining  = (strtotime($harvest_date)-strtotime(date('Y-m-d')))/(60*60*24);

                         if($crop_detail->image == ''){
                                $crop_image = '';
                            }
                            else{
                                $crop_image = $crop_detail->image;
                            }

                        $sub_channel_array=[
                         'sub_channel'=> $k,   
                         'id'=> $value->id,
                         'name' => $crop_detail->name ,
                         'crop_id' => $value->crop_id,
                         'category_id' => $value->category_id,
                         'description' => $crop_detail->description,
                         'plant_age' => $age.' days' ,
                         'channel_no'=> $value->channel_no,
                         'current_stage' => $current_stage,
                         'file_directory'=> url('/').'/crops/',
                         'image' => $crop_image,
                         'planted_date' => $value->planted_on,
                         'harvesting_date'=> $days_remaining
                     ];

                     }
                     else{
                        $sub_channel_array=[
                         'sub_channel'=> $k,    
                         'id'=> '',
                         'name' => '' ,
                         'crop_id' => '',
                         'category_id' =>'',
                         'description' => '',
                         'plant_age' => '' ,
                         'channel_no'=> $count,
                         'current_stage' => '',
                         'file_directory'=> '',
                         'image' => '',
                         'planted_date' => '',
                         'harvesting_date'=> ''
                     ];
                         
                     }

                      array_push($channel_array['sub_chanel'], $sub_channel_array);
                 }

                 $crops[]=$channel_array; 
                 $channel[]= $count ; 
                 $data = $crops ;
             $count++;
           }

           return response()->json([
    		       'status' => '1',
    		       'message' => 'Success',
    		       'data'=>$data ]);
    	   }

    	else{

    		return response()->json([
    		       'status' => '0',
    		       'message' => 'Insufficient Inputs',
    		       'data'=>$data ]);
    	}

    }


    public function alerts(Request $request){

        $pod_id = $request->pod_id;
        $user_id = $request->user_id;

        $data = array();

        $week = date('Y-m-d',strtotime('+7 days'));

        $channels = Cultivation::where('pod_id', $pod_id)->where('user_id' , $user_id)->get();

        foreach ($channels as $key => $value) {
            $growth = GrowthDuration::where('crop_id', $value->crop_id)->first();
            $harvest = $growth->harvesting ;

            $harvest_range= preg_split("/[-:]/", $harvest);
            $harvest_start = $harvest_range[0];

            $harvest_date = date('Y-m-d', strtotime($value->planted_on . ' + '. $harvest_start . 'days'));

            if($harvest_date >= date('Y-m-d') && $harvest_date <= $week ){
               
                $days_remaining  = (strtotime($harvest_date)-strtotime(date('Y-m-d')))/(60*60*24);
                $crop = Crop::where('id',$value->crop_id)->first();

                $data[]= ['image' => url('/').'/crops/'.$crop->image,
                          'subject' =>$crop->name,
                          'Channel' => $value->channel_no,
                          'subchannel' => $value->sub_channel ,
                          'message' => 'Harvesting in '.$days_remaining.' Days',
                          'alert_type' => 'Reminder' ];
               
            }

            if($value->pruning == date('Y-m-d')){
                $data[]= ['image' => url('/').'/crops/'.$crop->image,
                          'subject' =>$crop->name,
                          'Channel' => $value->channel_no,
                          'subchannel' => $value->sub_channel ,
                          'message' => 'Pruning Day',
                          'alert_type' => 'Reminder' ];

            }

            if($value->staking == date('Y-m-d')){
                $data[]= ['image' => url('/').'/crops/'.$crop->image,
                          'subject' =>$crop->name,
                          'Channel' => $value->channel_no,
                          'subchannel' => $value->sub_channel ,
                          'message' => 'Staking Day',
                          'alert_type' => 'Reminder' ];

            }

            if($value->nutrition_addition == date('Y-m-d')){
                $data[]= ['image' => url('/').'/crops/'.$crop->image,
                          'subject' =>$crop->name,
                          'Channel' => $value->channel_no,
                          'subchannel' => $value->sub_channel ,
                          'message' => 'Add Nutritions to Crop today',
                          'alert_type' => 'Reminder' ];

            }

            if($value->spray1 == date('Y-m-d')){
                $data[]= ['image' => url('/').'/crops/'.$crop->image,
                          'subject' =>$crop->name,
                          'Channel' => $value->channel_no,
                          'subchannel' => $value->sub_channel ,
                          'message' => 'Do first round of Spray on plants today',
                          'alert_type' => 'Reminder' ];

            }

            if($value->spray2 == date('Y-m-d')){
                $data[]= ['image' => url('/').'/crops/'.$crop->image,
                          'subject' =>$crop->name,
                          'Channel' => $value->channel_no,
                          'subchannel' => $value->sub_channel ,
                          'message' => 'Do secound round of Spray on plants today',
                          'alert_type' => 'Reminder' ];

            }

            if($value->spray3 == date('Y-m-d')){
                $data[]= ['image' => url('/').'/crops/'.$crop->image,
                          'subject' =>$crop->name,
                          'Channel' => $value->channel_no,
                          'subchannel' => $value->sub_channel ,
                          'message' => 'Do final round of Spray on plants today',
                          'alert_type' => 'Reminder' ];

            }

        }

       
        /*$data[] = [
            'image' => url('/').'/crops/amarnath.jpg',
            'subject' => 'Amarnath',
            'Channel' => '1' ,
            'subchannel' => 'A',
            'message' => 'harvesting in 1 day(s)' ,
            'alert_type' => 'Reminder'
        ];

         $data[] = [
            'image' => url('/').'/crops/amarnath.jpg',
            'subject' => 'Amarnath',
            'Channel' => '1' ,
            'subchannel' => 'B',
            'message' => 'harvesting in 11 day(s)' ,
            'alert_type' => 'Reminder'
        ];
*/

        return response()->json([
                   'status' => '1',
                   'data'=>$data ]);


    }

    public function crop_details($id){
       // print_r($id); die();
        $value= Cultivation::where('id',$id)->first();
        $crop_detail = Crop::where('id' , $value->crop_id)->first();
        $crop_growth = GrowthDuration::where('crop_id',$value->crop_id)->where('category_id', $value->category_id)->first();

        $planting_date = $value->planted_on ;
        $today = date('Y-m-d');
        $age = (strtotime($today)-strtotime($planting_date))/(60*60*24);

        $seedling_day = $crop_growth->seedling;
        $young = $crop_growth->young_plants;
        $matured = $crop_growth->matured;
        if($value->category_id == '5'){
            $vegetative = $crop_growth->vegetative_phase;
            $flowering = $crop_growth->flowering_stage;
            $fruiting = $crop_growth->fruiting_stage;

            $vegetative_range= preg_split("/[-:]/", $vegetative);
            $vegetative_start = $vegetative_range[0];
            $vegetative_end = $vegetative_range[1];

            $flowering_range= preg_split("/[-:]/", $flowering);
            $flowering_start = $flowering_range[0];
            $flowering_end = $flowering_range[1];

            $fruitingd_range= preg_split("/[-:]/", $fruiting);
            $fruiting_start = $fruitingd_range[0];
            $fruiting_end = $fruitingd_range[1];
            }
            else if($value->category_id != '5'){
            $matured_range= preg_split("/[-:]/", $matured);
            $matured_start = $matured_range[0];
            $matured_end = $matured_range[1];

            }
            
            $harvest = $crop_growth->harvesting ;

            $seedling_range= preg_split("/[-:]/", $seedling_day);
            $seedling_start = $seedling_range[0];
            $seedling_end = $seedling_range[1];

            $young_range= preg_split("/[-:]/", $young);
            $young_start = $young_range[0];
            $young_end = $young_range[1];

            
            $harvest_range= preg_split("/[-:]/", $harvest);
            $harvest_start = $harvest_range[0];
            $harvest_end = $harvest_range[1];
           
           if($value->category_id != '5'){
            if($age < $seedling_start){
                $current_stage = "Planted";

            }

            else if($age >= $seedling_start && $age < $young_start){
                  $current_stage = "Seedling";
                  $src =$crop_growth->seeding_image; 
            }

            else if($age >= $young_start && $age < $matured_start){
                  $current_stage = "Young Plants";
                  $src =$crop_growth->young_image;
            }
           else if($age >= $matured_start && $age < $harvest_start){
                  $current_stage = "Matured Plant";
                  $src =$crop_growth->matured_image;
            }
            else  if($age >= $harvest_start){
                 $current_stage = "Harvest";
                 $src =$crop_growth->harvesting_image;
            }
           }
           else {
              if($age < $seedling_start){
                $current_stage = "Planted";

            }

            else if($age >= $seedling_start && $age < $young_start){
                  $current_stage = "Seedling";
                  $src =$crop_growth->seeding_image; 
            }

            else if($age >= $young_start && $age < $vegetative_start ){
                  $current_stage = "Young Plants";
                  $src =$crop_growth->young_image;
            }
           else if($age >= $vegetative_start && $age < $flowering_start){
                  $current_stage = "Vegitative Phase";
                  $src =$crop_growth->matured_image;
            }

            else if($age >= $flowering_start && $age < $fruiting_start){
                  $current_stage = "Flowering Stage";
                  $src =$crop_growth->matured_image;
            }

            else if($age >= $fruiting_start && $age < $harvest_start){
                  $current_stage = "Fruiting Stage";
                  $src =$crop_growth->matured_image;
            }

            else  if($age >= $harvest_start){
                 $current_stage = "Harvest";
                 $src = $crop_growth->harvesting_image;
            }

           } 
       
            
            $harvest_date_range= preg_split("/[-:]/", $harvest);
            $harvest_start_date = $harvest_date_range[0];
            $harvest_date = date('Y-m-d', strtotime($planting_date . ' + '. $harvest_start_date . 'days'));

            $days_remaining  = (strtotime($harvest_date)-strtotime(date('Y-m-d')))/(60*60*24);

            if($crop_detail->image == ''){
                $crop_image = '';
            }
            else{
                $crop_image = $crop_detail->image;
            }
           
           $is_pruning='0';$is_staking='0';$is_nutrition='0';$is_spray1='0';$is_spray2='0';$is_spray3='0';

            if(Activity::where('user_id' , $value->user_id)->where('cultivation_id' ,$id)->where('activity','pruning')->exists()){
              $is_pruning = '1';
            }
            if(Activity::where('user_id' , $value->user_id)->where('cultivation_id' ,$id)->where('activity','staking')->exists()){
              $is_staking = '1';
            }
            if(Activity::where('user_id' , $value->user_id)->where('cultivation_id' ,$id)->where('activity','nutrition')->exists()){
              $is_nutrition = '1';
            }
            if(Activity::where('user_id' , $value->user_id)->where('cultivation_id' ,$id)->where('activity','spray1')->exists()){
              $is_spray1 = '1';
            }
            if(Activity::where('user_id' , $value->user_id)->where('cultivation_id' ,$id)->where('activity','spray2')->exists()){
              $is_spray2 = '1';
            }
            if(Activity::where('user_id' , $value->user_id)->where('cultivation_id' ,$id)->where('activity','spray3')->exists()){
              $is_spray3 = '1';
            }

            $sub_channel_array=[
             'sub_channel'=> $value->sub_channel,   
             'id'=> $value->id,
             'name' => $crop_detail->name ,
             'crop_id' => $value->crop_id,
             'category_id' => $value->category_id,
             'description' => $crop_detail->description,
             'plant_age' => $age.' days' ,
             'channel_no'=> $value->channel_no,
             'current_stage' => $current_stage,
             'file_directory'=> url('/').'/crops/',
             'image' => $crop_image,
             'planted_date' => $value->planted_on,
             'harvesting_date'=> $harvest_date,
             'pruning' => $value->pruning ,
             'is_pruning_done' => $is_pruning, 
             'staking' => $value->staking ,
             'is_staking_done' => $is_staking, 
             'nutrition' => $value->nutrition_addition ,
             'is_nutrition_added' => $is_nutrition, 
             'spray1' => $value->spray1,
             'is_spary1_done' => $is_spray1, 
             'spray2' => $value->spray2,
             'is_spray2_done' => $is_spray2, 
             'spray3' => $value->spray3,
             'is_spray3_done' => $is_spray3
         ];

          return response()->json([
                   'status' => '1',
                   'message' => 'Success',
                   'data'=>$sub_channel_array ]);
     

    }

    public function save_activity(Request $request){

        if(isset($request->user_id) && isset($request->activity) && isset($request->id)){
            $imagearray = array();
            $fileName='';

            if($file = $request->hasFile('images')) {

            foreach($_FILES['images']['name'] as $key=>$val){ 
                
               $fileName = basename($_FILES['images']['name'][$key]); 
               $temp = explode(".", $fileName);  
               $fileName = rand('111111','999999') . '.' . end($temp);
               $destinationPath = public_path().'/activity/'.$fileName ;
               move_uploaded_file($_FILES["images"]["tmp_name"][$key], $destinationPath);
               $imagearray[] = $fileName ;
        
            }

          }
          $imageNames = implode(',', $imagearray);

          $activity = Activity::create([
            'user_id' => $request->user_id ,
            'cultivation_id' => $request->id ,
            'activity' => $request->activity ,
            'feedback' => $request->feedback,
            'images' => $imageNames]);

          if($activity){
            return response()->json([
                   'status' => '1',
                   'message' => 'Activity saved Successfully',
                   ]);
          }
          else{
            return response()->json([
                   'status' => '0',
                   'message' => 'Something went Wrong',
                   ]);

          }
          
           
        }
        else{
            return response()->json([
                   'status' => '0',
                   'message' => 'UnAuthorised',
                   ]);

        }

    }
}
